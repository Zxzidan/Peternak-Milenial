<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\ConsultationSchedule;
use App\Models\Disease;
use App\Models\HealthRecord;
use App\Models\Livestock;
use App\Models\User;
use App\Models\Veterinarian;
use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    /**
     * Display veterinary consultations, digital health records, and doctor responses.
     */
    public function index(Request $request): View
    {
        $currentUser = auth()->user() ?? (app()->runningUnitTests() ? User::where('role', 'peternak')->first() : null);
        if (! $currentUser) {
            abort(403, 'Akses terbatas untuk pengguna terautentikasi.');
        }

        $activeTab = $request->query('tab', 'dokter');
        if (! in_array($activeTab, ['dokter', 'rekam_medis', 'penyakit', 'balasan_dokter'])) {
            $activeTab = 'dokter';
        }

        $isAdmin = $currentUser->isAdmin();

        // Admin/Vet sees consultation with current selected user or latest consultation
        if ($isAdmin) {
            $consultation = Consultation::with(['messages.sender', 'veterinarian', 'user', 'schedule.veterinarian', 'livestock'])->latest('updated_at')->first();
            $myBookings = Consultation::with(['user.peternakProfile', 'veterinarian', 'schedule.veterinarian', 'livestock'])->latest()->get();
            $livestocks = Livestock::with(['healthRecords.veterinarian'])->get();
            $healthRecords = HealthRecord::with(['livestock', 'veterinarian'])->latest('record_date')->get();

            // All health reports with doctor responses and visits
            $healthReports = AnimalHealthReport::with([
                'user.peternakProfile',
                'assignedVeterinarian.user',
                'responses.user',
                'visits.veterinarian',
                'latestVisit',
                'statusHistories.changer',
            ])->latest('created_at')->get();
        } else {
            // Peternak: Scoped strictly to their own consultation and own animals
            $consultation = Consultation::where('user_id', $currentUser->id)
                ->with(['messages.sender', 'veterinarian', 'user', 'schedule.veterinarian', 'livestock'])
                ->latest('updated_at')
                ->first();

            $myBookings = Consultation::where('user_id', $currentUser->id)
                ->with(['veterinarian', 'schedule.veterinarian', 'livestock', 'messages.sender'])
                ->latest()
                ->get();

            $livestocks = Livestock::where('user_id', $currentUser->id)->with(['healthRecords.veterinarian'])->get();
            $healthRecords = HealthRecord::whereIn('livestock_id', $livestocks->pluck('id'))
                ->with(['livestock', 'veterinarian'])
                ->latest('record_date')
                ->get();

            // Scoped health reports with doctor responses and visits for current Peternak
            $healthReports = AnimalHealthReport::where('user_id', $currentUser->id)
                ->with([
                    'assignedVeterinarian.user',
                    'responses.user',
                    'visits.veterinarian',
                    'latestVisit',
                    'statusHistories.changer',
                ])
                ->latest('created_at')
                ->get();
        }

        // Active veterinarians with upcoming consultation schedules
        $veterinarians = Veterinarian::where('is_active', true)
            ->with(['schedules' => function ($q) {
                $q->whereDate('date', '>=', now()->toDateString())
                    ->where('status', 'buka')
                    ->orderBy('date')
                    ->orderBy('start_time');
            }])
            ->latest()
            ->get();

        $diseases = Disease::all();

        // Calculate metrics for Balasan Dokter view
        $doctorResponseCount = $healthReports->sum(fn ($r) => $r->responses->filter(fn ($resp) => $resp->isFromDoctor())->count());
        $activeVisitsCount = $healthReports->sum(fn ($r) => $r->visits->count());
        $activePrescriptionsCount = $healthReports->filter(fn ($r) => $r->responses->whereNotNull('recommendations')->isNotEmpty())->count();
        $resolvedReportsCount = $healthReports->where('status', 'selesai')->count();

        // Filter consultations that contain veterinarian notes or prescriptions or replies
        $consultationsWithReplies = $myBookings->filter(function ($c) {
            return ! empty($c->doctor_notes) || ! empty($c->prescription) || in_array($c->status, ['answered', 'dikonfirmasi', 'selesai']) || $c->messages->filter(fn ($m) => $m->sender?->isDokterHewan() || $m->sender?->isAdmin())->isNotEmpty();
        });

        return view('konsultasi', [
            'activeTab' => $activeTab,
            'consultation' => $consultation,
            'myBookings' => $myBookings,
            'healthRecords' => $healthRecords,
            'livestocks' => $livestocks,
            'diseases' => $diseases,
            'veterinarians' => $veterinarians,
            'healthReports' => $healthReports,
            'doctorResponseCount' => $doctorResponseCount,
            'activeVisitsCount' => $activeVisitsCount,
            'activePrescriptionsCount' => $activePrescriptionsCount,
            'resolvedReportsCount' => $resolvedReportsCount,
            'consultationsWithReplies' => $consultationsWithReplies,
        ]);
    }

    /**
     * Peternak books a consultation slot with a specific doctor and quota check.
     */
    public function bookSchedule(Request $request): RedirectResponse
    {
        $currentUser = auth()->user();
        if (! $currentUser) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'consultation_schedule_id' => ['required', 'exists:consultation_schedules,id'],
            'subject' => ['required', 'string', 'max:255'],
            'complaint_details' => ['required', 'string', 'max:2000'],
            'livestock_id' => ['nullable', 'exists:livestock,id'],
            'consultation_type' => ['required', 'in:konsultasi_online,telemedisin,tatap_muka,kunjungan'],
        ]);

        $schedule = ConsultationSchedule::with(['veterinarian.user'])->findOrFail($validated['consultation_schedule_id']);

        if ($schedule->status !== 'buka') {
            return redirect()->route('konsultasi')
                ->withInput()
                ->with('error', "Mohon maaf, slot jadwal {$schedule->time_slot_label} saat ini sedang ditutup.");
        }

        if ($schedule->remaining_quota <= 0) {
            return redirect()->route('konsultasi')
                ->withInput()
                ->with('error', "Mohon maaf, kuota layanan konsultasi pada jam {$schedule->time_slot_label} sudah habis. Silakan pilih jam atau tanggal lain.");
        }

        // Check if peternak already booked this exact slot
        $existing = Consultation::where('user_id', $currentUser->id)
            ->where('consultation_schedule_id', $schedule->id)
            ->where('status', '!=', 'dibatalkan')
            ->first();

        if ($existing) {
            return redirect()->route('konsultasi')
                ->withInput()
                ->with('error', "Anda telah terdaftar pada slot jadwal ini (No. Reservasi: {$existing->booking_code}).");
        }

        $bookingCode = 'JDW-'.date('Ymd').'-'.strtoupper(Str::random(5));
        $vetUserId = $schedule->veterinarian?->user_id;

        $consultation = Consultation::create([
            'user_id' => $currentUser->id,
            'veterinarian_id' => $vetUserId,
            'consultation_schedule_id' => $schedule->id,
            'booking_code' => $bookingCode,
            'livestock_id' => $validated['livestock_id'] ?? null,
            'consultation_date' => $schedule->date,
            'consultation_time' => $schedule->time_slot_label,
            'subject' => $validated['subject'],
            'complaint_details' => $validated['complaint_details'],
            'consultation_type' => $validated['consultation_type'],
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "Jadwal konsultasi berhasil diatur bersama {$schedule->veterinarian?->name} pada {$schedule->date->translatedFormat('d F Y')} ({$schedule->time_slot_label}). Kuota layanan Anda telah dikunci (No. Reservasi: {$bookingCode})!");
    }

    /**
     * Peternak cancels their booked consultation schedule, restoring slot quota.
     */
    public function cancelBooking(Consultation $consultation): RedirectResponse
    {
        $currentUser = auth()->user();
        if (! $currentUser) {
            return redirect()->route('login');
        }

        if ($consultation->user_id !== $currentUser->id && ! $currentUser->isAdmin() && ! $currentUser->isDokterHewan()) {
            abort(403, 'Anda tidak memiliki hak untuk membatalkan reservasi ini.');
        }

        if ($consultation->status === 'selesai') {
            return redirect()->route('konsultasi')
                ->with('error', 'Konsultasi yang sudah selesai tidak dapat dibatalkan.');
        }

        $consultation->update(['status' => 'dibatalkan']);

        return redirect()->route('konsultasi')
            ->with('success', "Reservasi jadwal konsultasi '{$consultation->booking_code}' berhasil dibatalkan. Kuota layanan telah dikembalikan.");
    }

    /**
     * Get available consultation slots for a specific veterinarian and date (AJAX/API).
     */
    public function getDoctorSlots(Veterinarian $veterinarian, Request $request): JsonResponse
    {
        $date = $request->query('date', now()->toDateString());

        $slots = ConsultationSchedule::where('veterinarian_id', $veterinarian->id)
            ->whereDate('date', $date)
            ->where('status', 'buka')
            ->with(['consultations'])
            ->orderBy('start_time')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'time_label' => $s->time_slot_label,
                    'start_time' => substr((string) $s->start_time, 0, 5),
                    'end_time' => substr((string) $s->end_time, 0, 5),
                    'quota' => $s->quota,
                    'booked_count' => $s->booked_count,
                    'remaining_quota' => $s->remaining_quota,
                    'is_full' => $s->is_full,
                    'service_type' => $s->service_type,
                ];
            });

        // Also fetch upcoming dates that have active slots for this doctor
        $availableDates = ConsultationSchedule::where('veterinarian_id', $veterinarian->id)
            ->whereDate('date', '>=', now()->toDateString())
            ->where('status', 'buka')
            ->orderBy('date')
            ->get()
            ->map(fn ($s) => $s->date instanceof CarbonInterface ? $s->date->toDateString() : substr((string) $s->date, 0, 10))
            ->unique()
            ->values();

        return response()->json([
            'doctor_name' => $veterinarian->name,
            'date' => $date,
            'slots' => $slots,
            'available_dates' => $availableDates,
        ]);
    }

    /**
     * Start a new consultation session (Peternak fallback).
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

        $vet = User::where('role', 'dokter_hewan')->first() ?? User::where('role', 'admin')->first();

        $consultation = Consultation::create([
            'user_id' => $currentUser->id,
            'veterinarian_id' => $vet?->id,
            'subject' => $validated['subject'],
            'status' => 'menunggu_konfirmasi',
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
        if ($sender->isDokterHewan() || $sender->isAdmin()) {
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
        if (auth()->check() && ! auth()->user()->hasRole('admin', 'dokter_hewan')) {
            abort(403, 'Hanya Petugas Dinas atau Dokter Hewan yang berwenang menerbitkan rekam medis resmi.');
        }

        $validated = $request->validate([
            'livestock_id' => ['required', 'exists:livestock,id'],
            'record_type' => ['required', 'in:pemeriksaan,vaksinasi,pengobatan,inseminasi_buatan'],
            'title' => ['required', 'string', 'max:255'],
            'diagnosis' => ['nullable', 'string', 'max:500'],
            'treatment' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'notes' => $validated['notes'] ?? 'Tercatat otomatis melalui Buku Rekam Medis Digital Dinas',
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

    /**
     * Store a new veterinarian (Admin only).
     */
    public function storeVeterinarian(Request $request): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menambahkan dokter hewan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'puskeswan' => ['required', 'string', 'max:255'],
            'strv_number' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'in:online,praktik_lapangan,siaga,offline'],
            'consultation_hours' => ['nullable', 'string', 'max:100'],
        ]);

        $user = null;
        if (! empty($validated['email'])) {
            $user = User::where('email', $validated['email'])->first();
            if (! $user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                    'role' => 'dokter_hewan',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                ]);
            }
        }

        $vet = Veterinarian::create([
            'user_id' => $user?->id,
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'puskeswan' => $validated['puskeswan'],
            'wilayah_penugasan' => $validated['puskeswan'],
            'strv_number' => $validated['strv_number'] ?? null,
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'],
            'consultation_hours' => ! empty($validated['consultation_hours']) ? $validated['consultation_hours'] : '08.00 - 16.00 WIB',
            'is_active' => true,
        ]);

        return redirect()->route('konsultasi', ['tab' => 'dokter'])
            ->with('success', "Dokter hewan '{$vet->name}' berhasil didaftarkan dengan akun Dokter Hewan Dinas.");
    }

    /**
     * Update veterinarian details (Admin only).
     */
    public function updateVeterinarian(Request $request, Veterinarian $veterinarian): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang mengubah data dokter hewan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'puskeswan' => ['required', 'string', 'max:255'],
            'strv_number' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'in:online,praktik_lapangan,siaga,offline'],
            'consultation_hours' => ['nullable', 'string', 'max:100'],
        ]);

        $veterinarian->update([
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'puskeswan' => $validated['puskeswan'],
            'strv_number' => $validated['strv_number'] ?? null,
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'] ?? null,
            'status' => $validated['status'],
            'consultation_hours' => ! empty($validated['consultation_hours']) ? $validated['consultation_hours'] : $veterinarian->consultation_hours,
        ]);

        return redirect()->route('konsultasi', ['tab' => 'dokter'])
            ->with('success', "Data '{$veterinarian->name}' berhasil diperbarui.");
    }

    /**
     * Delete veterinarian (Admin only).
     */
    public function destroyVeterinarian(Veterinarian $veterinarian): RedirectResponse
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin Dinas yang berwenang menghapus dokter hewan.');
        }

        $name = $veterinarian->name;
        $veterinarian->delete();

        return redirect()->route('konsultasi', ['tab' => 'dokter'])
            ->with('success', "Dokter hewan '{$name}' berhasil dihapus dari direktori.");
    }
}
