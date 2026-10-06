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
        $userId = auth()->id() ?? User::where('role', 'peternak')->value('id') ?? 4;

        $trainings = Training::withCount('registrations')
            ->orderBy('start_date')
            ->get();

        $materials = LearningMaterial::latest()->get();

        $certificates = Certificate::with(['training', 'user'])
            ->latest('issued_date')
            ->get();

        $myRegistrations = TrainingRegistration::with('training')
            ->where('user_id', $userId)
            ->latest('registered_at')
            ->get();

        $myRegisteredTrainingIds = $myRegistrations->pluck('training_id')->toArray();

        return view('pelatihan', [
            'trainings' => $trainings,
            'materials' => $materials,
            'certificates' => $certificates,
            'myRegistrations' => $myRegistrations,
            'myRegisteredTrainingIds' => $myRegisteredTrainingIds,
        ]);
    }

    /**
     * Register a peternak to a specific training.
     */
    public function register(Request $request, Training $training): RedirectResponse
    {
        $user = auth()->user() ?? User::where('role', 'peternak')->first() ?? User::first();

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
     * Cancel training registration and restore quota.
     */
    public function cancelRegistration(TrainingRegistration $registration): RedirectResponse
    {
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
     * Store a new training (by officer / admin).
     */
    public function store(Request $request): RedirectResponse
    {
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
     * Delete a training.
     */
    public function destroy(Training $training): RedirectResponse
    {
        $title = $training->title;
        $training->delete();

        return redirect()->route('pelatihan')
            ->with('success', "Program Bimtek '{$title}' berhasil dihapus.");
    }
}
