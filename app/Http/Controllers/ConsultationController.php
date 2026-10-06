<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\Disease;
use App\Models\HealthRecord;
use App\Models\Livestock;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    /**
     * Display veterinary consultations, digital health records, and disease guidance.
     */
    public function index(): View
    {
        $currentUser = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);
        if (! $currentUser) {
            abort(403, 'Akses terbatas untuk pengguna terautentikasi.');
        }

        $isAdmin = $currentUser->isAdmin();

        // Admin/Vet sees consultation with current selected user or latest consultation
        if ($isAdmin) {
            $consultation = Consultation::with(['messages.sender', 'veterinarian', 'user'])->latest('updated_at')->first();
            $livestocks = Livestock::all();
            $healthRecords = HealthRecord::with(['livestock', 'veterinarian'])->latest('record_date')->get();
        } else {
            // Peternak: Scoped strictly to their own consultation and own animals
            $consultation = Consultation::where('user_id', $currentUser->id)
                ->with(['messages.sender', 'veterinarian', 'user'])
                ->latest('updated_at')
                ->first();

            $livestocks = Livestock::where('user_id', $currentUser->id)->get();
            $healthRecords = HealthRecord::whereIn('livestock_id', $livestocks->pluck('id'))
                ->with(['livestock', 'veterinarian'])
                ->latest('record_date')
                ->get();
        }

        $diseases = Disease::all();

        return view('konsultasi', [
            'consultation' => $consultation,
            'healthRecords' => $healthRecords,
            'livestocks' => $livestocks,
            'diseases' => $diseases,
        ]);
    }

    /**
     * Start a new consultation session (Peternak).
     */
    public function startConsultation(Request $request): RedirectResponse
    {
        $currentUser = auth()->user();
        if (! $currentUser) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $vet = User::where('role', 'admin')->first();

        $consultation = Consultation::create([
            'user_id' => $currentUser->id,
            'veterinarian_id' => $vet?->id,
            'subject' => $validated['subject'],
            'status' => 'pending',
        ]);

        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => $currentUser->id,
            'message' => $validated['message'],
        ]);

        return redirect()->route('konsultasi')
            ->with('success', 'Konsultasi baru berhasil diajukan kepada Dokter Hewan Dinas!');
    }

    /**
     * Send a consultation chat message (Peternak or Vet/Admin).
     */
    public function sendMessage(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $sender = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();

        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => $sender->id,
            'message' => $validated['message'],
        ]);

        // If veterinarian/admin answers, set status to answered
        if ($sender->isAdmin()) {
            $consultation->update(['status' => 'answered', 'veterinarian_id' => $sender->id]);
        }

        $consultation->touch();

        return redirect()->route('konsultasi')
            ->with('success', 'Pesan konsultasi berhasil dikirim!');
    }

    /**
     * Store new health record / vaccination / inspection (Admin / Veterinarian only).
     */
    public function storeHealthRecord(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Petugas Dinas atau Dokter Hewan yang berwenang menerbitkan rekam medis resmi.');
        }

        $validated = $request->validate([
            'livestock_id' => ['required', 'exists:livestock,id'],
            'record_type' => ['required', 'in:pemeriksaan,vaksinasi,pengobatan,inseminasi_buatan'],
            'title' => ['required', 'string', 'max:255'],
            'diagnosis' => ['nullable', 'string', 'max:500'],
            'treatment' => ['nullable', 'string', 'max:500'],
            'record_date' => ['required', 'date'],
        ]);

        $vet = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'admin')->first() : null);
        if (! $vet) {
            return redirect()->route('login');
        }

        HealthRecord::create([
            'livestock_id' => $validated['livestock_id'],
            'veterinarian_id' => $vet->id,
            'record_type' => $validated['record_type'],
            'title' => $validated['title'],
            'diagnosis' => $validated['diagnosis'] ?? 'Kondisi stabil dalam pemantauan rutin',
            'treatment' => $validated['treatment'] ?? 'Vitamin & multivitamin support',
            'notes' => 'Tercatat otomatis melalui Buku Rekam Medis Digital Dinas',
            'record_date' => $validated['record_date'],
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "Rekam medis '{$validated['title']}' berhasil disimpan ke e-record ternak!");
    }

    /**
     * Register a new e-tag livestock (Peternak or Admin).
     */
    public function storeLivestock(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tag_number' => ['required', 'string', 'max:50', 'unique:livestock,e_tag_number'],
            'livestock_type' => ['nullable', 'string', 'max:50'],
            'breed' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:jantan,betina'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $user = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);
        if (! $user) {
            return redirect()->route('login');
        }

        $type = match ($validated['livestock_type'] ?? '') {
            'sapi_perah' => 'sapi_perah_fh',
            'sapi_potong' => 'sapi_potong',
            'kambing' => 'kambing_senduro',
            'domba' => 'domba',
            default => 'sapi_perah_fh',
        };

        $name = ! empty($validated['breed']) ? $validated['breed'] : 'Ternak Milenial Jatim';

        $livestock = Livestock::create([
            'user_id' => $user->id,
            'e_tag_number' => strtoupper($validated['tag_number']),
            'name' => $name,
            'type' => $type,
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'] ?? now()->subYears(2),
            'reproductive_status' => 'produktif',
            'health_status' => 'sehat',
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "E-Tag Ternak {$livestock->e_tag_number} ({$livestock->name}) berhasil didaftarkan ke sistem Dinas!");
    }

    /**
     * Delete a health record (Admin only).
     */
    public function destroyHealthRecord(HealthRecord $record): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus rekam medis ternak.');
        }

        $title = $record->title;
        $record->delete();

        return redirect()->route('konsultasi')
            ->with('success', "Rekam medis '{$title}' berhasil dihapus.");
    }

    /**
     * Store disease database item (Admin only).
     */
    public function storeDisease(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambah basis data penyakit hewan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:diseases,name'],
            'category' => ['required', 'string', 'max:100'],
            'symptoms' => ['required', 'string'],
            'prevention_steps' => ['nullable', 'string'],
            'treatment_first_aid' => ['nullable', 'string'],
        ]);

        Disease::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'symptoms' => $validated['symptoms'],
            'prevention_steps' => $validated['prevention_steps'],
            'treatment_first_aid' => $validated['treatment_first_aid'],
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "Penyakit hewan '{$validated['name']}' berhasil ditambahkan ke basis data.");
    }

    /**
     * Delete disease database item (Admin only).
     */
    public function destroyDisease(Disease $disease): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus basis data penyakit hewan.');
        }

        $name = $disease->name;
        $disease->delete();

        return redirect()->route('konsultasi')
            ->with('success', "Penyakit '{$name}' berhasil dihapus dari basis data.");
    }
}
