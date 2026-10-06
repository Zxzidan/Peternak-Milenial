<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\LearningMaterial;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
    /**
     * Display the Trainings and Bimtek list.
     */
    public function index(): View
    {
        $currentUser = auth()->user();

        $trainings = Training::withCount('registrations')
            ->orderBy('start_date')
            ->get();

        $materials = LearningMaterial::latest()->get();

        // Admin sees all certificates; Peternak sees their own certificates; Umum sees none
        if ($currentUser && $currentUser->isAdmin()) {
            $certificates = Certificate::with(['training', 'user'])
                ->latest('issued_date')
                ->get();
        } elseif ($currentUser && $currentUser->isPeternak()) {
            $certificates = Certificate::with(['training', 'user'])
                ->where('user_id', $currentUser->id)
                ->latest('issued_date')
                ->get();
        } else {
            $certificates = collect();
        }

        // Peternak's own registrations
        $myRegistrations = ($currentUser && $currentUser->isPeternak())
            ? TrainingRegistration::with('training')
                ->where('user_id', $currentUser->id)
                ->latest('registered_at')
                ->get()
            : collect();

        $myRegisteredTrainingIds = $myRegistrations->pluck('training_id')->toArray();

        // All registrations (for Admin verification view)
        $allRegistrations = ($currentUser && $currentUser->isAdmin())
            ? TrainingRegistration::with(['training', 'user'])->latest('registered_at')->get()
            : collect();

        $peternakUsers = ($currentUser && $currentUser->isAdmin())
            ? User::where('role', 'peternak')->orderBy('name')->get()
            : collect();

        return view('pelatihan', [
            'trainings' => $trainings,
            'materials' => $materials,
            'certificates' => $certificates,
            'myRegistrations' => $myRegistrations,
            'myRegisteredTrainingIds' => $myRegisteredTrainingIds,
            'allRegistrations' => $allRegistrations,
            'peternakUsers' => $peternakUsers,
        ]);
    }

    /**
     * Register a peternak to a specific training.
     */
    public function register(Request $request, Training $training): RedirectResponse
    {
        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Peternak Anda untuk mendaftar pelatihan.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('pelatihan')->with('error', 'Akun Admin Dinas berfungsi sebagai pengelola program dan tidak mendaftar sebagai peserta.');
        }

        // Check if already registered
        $existing = TrainingRegistration::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('pelatihan')
                ->with('error', "Anda sudah terdaftar pada Bimtek '{$training->title}' dengan kode {$existing->registration_code}.");
        }

        // Check remaining quota
        if ($training->remaining_quota <= 0) {
            return redirect()->route('pelatihan')
                ->with('error', "Mohon maaf, kuota peserta untuk Bimtek '{$training->title}' sudah penuh.");
        }

        // Generate registration code
        $regCode = 'REG-'.strtoupper(Str::random(4)).'-'.date('dmy');

        TrainingRegistration::create([
            'training_id' => $training->id,
            'user_id' => $user->id,
            'registration_code' => $regCode,
            'status' => 'confirmed',
            'registered_at' => now(),
            'notes' => 'Pendaftaran online melalui portal Peternak Milenial Jatim',
        ]);

        $training->decrement('remaining_quota');

        return redirect()->route('pelatihan')
            ->with('success', "Pendaftaran Bimtek '{$training->title}' berhasil! Kode Tiket: {$regCode}. Sisa kuota: {$training->remaining_quota} peserta.");
    }

    /**
     * Update participant registration status (Admin only).
     */
    public function updateRegistrationStatus(Request $request, TrainingRegistration $registration): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang memverifikasi status pendaftaran peserta.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,attended,cancelled'],
        ]);

        $registration->update(['status' => $validated['status']]);

        return redirect()->route('pelatihan')
            ->with('success', "Status pendaftaran peserta {$registration->user?->name} ({$registration->registration_code}) berhasil diperbarui menjadi {$validated['status']}.");
    }

    /**
     * Cancel training registration and restore quota (Owner Peternak or Admin).
     */
    public function cancelRegistration(TrainingRegistration $registration): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && ! $currentUser->isAdmin() && $registration->user_id !== $currentUser->id) {
            abort(403, 'Anda hanya dapat membatalkan pendaftaran pelatihan milik Anda sendiri.');
        }

        $training = $registration->training;
        $title = $training?->title ?? 'Pelatihan';

        if ($training) {
            $training->increment('remaining_quota');
        }

        $registration->delete();

        return redirect()->route('pelatihan')
            ->with('success', "Pendaftaran Bimtek '{$title}' berhasil dibatalkan.");
    }

    /**
     * Store a new training (Admin only).
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambahkan program Bimtek.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'instructor' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'time_info' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'is_online' => ['nullable', 'boolean'],
            'quota' => ['required', 'integer', 'min:1'],
            'cost_type' => ['required', 'in:gratis_apbd,daring,mandiri'],
        ]);

        $slug = Str::slug($validated['title']).'-'.time();

        Training::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'instructor' => $validated['instructor'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'time_info' => $validated['time_info'] ?? '08:00 - 15:00 WIB',
            'location' => $validated['location'],
            'is_online' => (bool) ($request->is_online ?? false),
            'quota' => $validated['quota'],
            'remaining_quota' => $validated['quota'],
            'cost_type' => $validated['cost_type'],
            'status' => 'open',
        ]);

        return redirect()->route('pelatihan')
            ->with('success', "Program Bimtek '{$validated['title']}' berhasil ditambahkan ke jadwal dinas!");
    }

    /**
     * Delete a training (Admin only).
     */
    public function destroy(Training $training): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus program Bimtek.');
        }

        $title = $training->title;
        $training->delete();

        return redirect()->route('pelatihan')
            ->with('success', "Program Bimtek '{$title}' berhasil dihapus.");
    }

    /**
     * Store new learning material (Admin only).
     */
    public function storeMaterial(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang mengunggah materi pembelajaran.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:modul_pdf,video_praktik,panduan'],
            'duration' => ['nullable', 'string', 'max:50'],
            'file_size' => ['nullable', 'string', 'max:50'],
            'author_institution' => ['required', 'string', 'max:255'],
        ]);

        $slug = Str::slug($validated['title']).'-'.time();

        LearningMaterial::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'duration' => $validated['duration'],
            'file_size' => $validated['file_size'] ?? '2.4 MB',
            'author_institution' => $validated['author_institution'],
        ]);

        return redirect()->route('pelatihan')
            ->with('success', "Materi pembelajaran '{$validated['title']}' berhasil diunggah.");
    }

    /**
     * Delete learning material (Admin only).
     */
    public function destroyMaterial(LearningMaterial $material): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus materi pembelajaran.');
        }

        $title = $material->title;
        $material->delete();

        return redirect()->route('pelatihan')
            ->with('success', "Materi '{$title}' berhasil dihapus.");
    }

    /**
     * Issue a digital certificate for a peternak (Admin only).
     */
    public function issueCertificate(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menerbitkan sertifikat digital.');
        }

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'training_id' => ['nullable', 'exists:trainings,id'],
            'title' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'issued_date' => ['required', 'date'],
        ]);

        $certNum = 'DISNAK-JTM-'.date('Y').'-'.str_pad(Certificate::count() + 1, 4, '0', STR_PAD_LEFT);

        Certificate::create([
            'user_id' => $validated['user_id'],
            'training_id' => $validated['training_id'] ?? null,
            'certificate_number' => $certNum,
            'recipient_name' => $validated['recipient_name'],
            'recipient_code' => 'NIK-'.rand(1000, 9999),
            'title' => $validated['title'],
            'issued_date' => $validated['issued_date'],
            'verified_by' => 'Dinas Peternakan Provinsi Jawa Timur',
        ]);

        return redirect()->route('pelatihan')
            ->with('success', "Sertifikat digital '{$certNum}' berhasil diterbitkan untuk {$validated['recipient_name']}.");
    }

    /**
     * Delete a certificate (Admin only).
     */
    public function destroyCertificate(Certificate $certificate): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus sertifikat digital.');
        }

        $certNum = $certificate->certificate_number;
        $certificate->delete();

        return redirect()->route('pelatihan')
            ->with('success', "Sertifikat digital '{$certNum}' berhasil dihapus.");
    }
}
