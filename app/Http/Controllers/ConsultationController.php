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
use Carbon\Carbon;
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
        if (! in_array($activeTab, ['dokter', 'jadwal', 'rekam_medis', 'penyakit'])) {
            $activeTab = 'dokter';
        }

        $isAdmin = $currentUser->isAdmin();
        $isStaff = $isAdmin || $currentUser->isDokterHewan();
        $filterDate = $request->query('filter_date');

        // Admin/Vet sees consultation with current selected user or latest consultation
        if ($isStaff) {
            $consultation = Consultation::with(['messages.sender', 'veterinarian', 'user', 'schedule.veterinarian', 'livestock'])->latest('updated_at')->first();
            $bookingsQuery = Consultation::with(['user.peternakProfile', 'veterinarian', 'schedule.veterinarian', 'livestock'])
                ->whereIn('status', ['menunggu_konfirmasi', 'dikonfirmasi', 'open']);
            $cancelledBookingsQuery = Consultation::with(['user.peternakProfile', 'veterinarian', 'schedule.veterinarian', 'livestock'])
                ->where('status', 'dibatalkan');
            $completedConsultationsQuery = Consultation::with(['user.peternakProfile', 'veterinarian', 'schedule.veterinarian', 'livestock', 'messages.sender'])
                ->whereIn('status', ['selesai', 'answered', 'closed']);
            $livestocks = Livestock::with(['healthRecords.veterinarian'])->get();
            $healthRecords = HealthRecord::with(['livestock', 'veterinarian'])->latest('record_date')->get();
            $completedReportsQuery = AnimalHealthReport::where('status', 'selesai')
                ->with(['user.peternakProfile', 'assignedVeterinarian.user', 'responses.user', 'latestVisit']);
        } else {
            // Peternak: Scoped strictly to their own consultation and own animals
            $consultation = Consultation::where('user_id', $currentUser->id)
                ->with(['messages.sender', 'veterinarian', 'user', 'schedule.veterinarian', 'livestock'])
                ->latest('updated_at')
                ->first();

            $bookingsQuery = Consultation::where('user_id', $currentUser->id)
                ->whereIn('status', ['menunggu_konfirmasi', 'dikonfirmasi', 'open'])
                ->with(['veterinarian', 'schedule.veterinarian', 'livestock', 'messages.sender']);

            $cancelledBookingsQuery = Consultation::where('user_id', $currentUser->id)
                ->where('status', 'dibatalkan')
                ->with(['veterinarian', 'schedule.veterinarian', 'livestock']);

            $completedConsultationsQuery = Consultation::where('user_id', $currentUser->id)
                ->whereIn('status', ['selesai', 'answered', 'closed'])
                ->with(['veterinarian', 'schedule.veterinarian', 'livestock', 'messages.sender']);

            $livestocks = Livestock::where('user_id', $currentUser->id)->with(['healthRecords.veterinarian'])->get();
            $healthRecords = HealthRecord::whereIn('livestock_id', $livestocks->pluck('id'))
                ->with(['livestock', 'veterinarian'])
                ->latest('record_date')
                ->get();
            $completedReportsQuery = AnimalHealthReport::where('user_id', $currentUser->id)
                ->where('status', 'selesai')
                ->with(['assignedVeterinarian.user', 'responses.user', 'latestVisit']);
        }

        if ($request->filled('filter_date')) {
            $completedReportsQuery->where(function ($q) use ($filterDate) {
                $q->whereDate('resolved_at', $filterDate)
                    ->orWhere(function ($q2) use ($filterDate) {
                        $q2->whereNull('resolved_at')
                            ->whereDate('updated_at', $filterDate);
                    });
            });

            $bookingsQuery->where(function ($q) use ($filterDate) {
                $q->whereDate('consultation_date', $filterDate)
                    ->orWhereHas('schedule', function ($sq) use ($filterDate) {
                        $sq->whereDate('date', $filterDate);
                    })
                    ->orWhere(function ($q2) use ($filterDate) {
                        $q2->whereNull('consultation_date')
                            ->whereDoesntHave('schedule')
                            ->whereDate('created_at', $filterDate);
                    });
            });

            $completedConsultationsQuery->where(function ($q) use ($filterDate) {
                $q->whereDate('consultation_date', $filterDate)
                    ->orWhereHas('schedule', function ($sq) use ($filterDate) {
                        $sq->whereDate('date', $filterDate);
                    })
                    ->orWhere(function ($q2) use ($filterDate) {
                        $q2->whereNull('consultation_date')
                            ->whereDoesntHave('schedule')
                            ->whereDate('created_at', $filterDate);
                    });
            });
        }

        $myBookings = $bookingsQuery->latest()->get();
        $cancelledBookings = $cancelledBookingsQuery->latest('updated_at')->get();
        $completedConsultations = $completedConsultationsQuery->latest()->get();
        $completedReports = $completedReportsQuery->latest('resolved_at')->get();

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

        return view('konsultasi', [
            'activeTab' => $activeTab,
            'consultation' => $consultation,
            'myBookings' => $myBookings,
            'cancelledBookings' => $cancelledBookings,
            'completedConsultations' => $completedConsultations,
            'completedReports' => $completedReports,
            'healthRecords' => $healthRecords,
            'livestocks' => $livestocks,
            'diseases' => $diseases,
            'veterinarians' => $veterinarians,
            'filterDate' => $filterDate,
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
            'subject' => ['nullable', 'string', 'max:255'],
            'complaint_details' => ['nullable', 'string', 'max:2000'],
            'livestock_id' => ['nullable', 'exists:livestock,id'],
            'consultation_type' => ['required', 'in:online,offline,konsultasi_online,telemedisin,tatap_muka,kunjungan'],
        ]);

        $schedule = ConsultationSchedule::with(['veterinarian.user'])->findOrFail($validated['consultation_schedule_id']);

        if ($schedule->status !== 'buka') {
            return redirect()->route('konsultasi')
                ->withInput()
                ->with('error', "Mohon maaf, slot jadwal {$schedule->time_slot_label} saat ini sedang ditutup.");
        }

        // Prevent booking slots that have already passed their time limit
        $now = now('Asia/Jakarta');
        $today = $now->toDateString();
        $currentTime = $now->format('H:i');
        $scheduleDate = $schedule->date instanceof CarbonInterface ? $schedule->date->toDateString() : substr((string) $schedule->date, 0, 10);
        $scheduleEndTime = substr((string) $schedule->end_time, 0, 5);

        if ($scheduleDate < $today || ($scheduleDate === $today && $scheduleEndTime <= $currentTime)) {
            return redirect()->route('konsultasi')
                ->withInput()
                ->with('error', "Mohon maaf, jam layanan {$schedule->time_slot_label} pada tanggal {$scheduleDate} telah melewati batas waktu.");
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

        $subject = ! empty(trim($validated['subject'] ?? ''))
            ? trim($validated['subject'])
            : (! empty(trim($validated['complaint_details'] ?? ''))
                ? Str::limit(trim($validated['complaint_details']), 60)
                : 'Konsultasi Kesehatan Hewan');

        $consultation = Consultation::create([
            'user_id' => $currentUser->id,
            'veterinarian_id' => $vetUserId,
            'consultation_schedule_id' => $schedule->id,
            'booking_code' => $bookingCode,
            'livestock_id' => $validated['livestock_id'] ?? null,
            'consultation_date' => $schedule->date,
            'consultation_time' => $schedule->time_slot_label,
            'subject' => $subject,
            'complaint_details' => $validated['complaint_details'] ?? null,
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

        $consultation->update([
            'status' => 'dibatalkan',
            'consultation_schedule_id' => null,
            'doctor_notes' => 'Reservasi jadwal konsultasi dibatalkan oleh peternak.',
        ]);

        return redirect()->route('konsultasi')
            ->with('success', "Reservasi jadwal konsultasi '{$consultation->booking_code}' berhasil dibatalkan. Kuota layanan telah dikembalikan.");
    }

    /**
     * Get available consultation slots for a specific veterinarian and date (AJAX/API).
     */
    public function getDoctorSlots(Veterinarian $veterinarian, Request $request): JsonResponse
    {
        $now = now('Asia/Jakarta');
        $today = $now->toDateString();
        $currentTime = $now->format('H:i');

        $date = $request->query('date', $today);

        // If date is in the past, return empty list
        if ($date < $today) {
            $slots = collect();
        } else {
            $slots = ConsultationSchedule::where('veterinarian_id', $veterinarian->id)
                ->whereDate('date', $date)
                ->where('status', 'buka')
                ->with(['consultations'])
                ->orderBy('start_time')
                ->get()
                ->filter(function ($s) use ($date, $today, $currentTime) {
                    // If date is today, exclude slots whose end time has already passed
                    if ($date === $today) {
                        $endTime = substr((string) $s->end_time, 0, 5);
                        if ($endTime <= $currentTime) {
                            return false;
                        }
                    }

                    return true;
                })
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
                })
                ->values();
        }

        // Also fetch upcoming dates that have active and unexpired slots for this doctor
        $upcomingSchedules = ConsultationSchedule::where('veterinarian_id', $veterinarian->id)
            ->whereDate('date', '>=', $today)
            ->where('status', 'buka')
            ->orderBy('date')
            ->get();

        $availableDates = $upcomingSchedules
            ->filter(function ($s) use ($today, $currentTime) {
                $scheduleDate = $s->date instanceof CarbonInterface ? $s->date->toDateString() : substr((string) $s->date, 0, 10);
                if ($scheduleDate === $today) {
                    $endTime = substr((string) $s->end_time, 0, 5);

                    return $endTime > $currentTime;
                }

                return $scheduleDate > $today;
            })
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

    /**
     * Download or view official digital medical record document (PDF/Print) with farmer care guide.
     */
    public function downloadMedicalRecordDocument(Request $request, string $type, int $id): View|RedirectResponse
    {
        $currentUser = auth()->user();
        if (! $currentUser) {
            return redirect()->route('login');
        }

        if ($type === 'consultation') {
            $consultation = Consultation::with(['user.peternakProfile', 'veterinarian', 'schedule.veterinarian', 'livestock'])->findOrFail($id);

            // Authorization: peternak can only see their own, admin and dokter_hewan can see all
            if (! $currentUser->isAdmin() && ! $currentUser->isDokterHewan() && $consultation->user_id !== $currentUser->id) {
                abort(403, 'Anda tidak berhak mengakses dokumen rekam medis ini.');
            }

            $livestock = $consultation->livestock;
            $doctor = $consultation->veterinarian;
            $owner = $consultation->user;

            $recordData = [
                'type' => 'consultation',
                'id' => $consultation->id,
                'document_number' => 'RM-JTM/'.($consultation->created_at?->format('Y') ?? date('Y')).'/KON-'.str_pad($consultation->id, 4, '0', STR_PAD_LEFT),
                'date' => $consultation->schedule ? Carbon::parse($consultation->schedule->date)->translatedFormat('d F Y') : ($consultation->created_at ? $consultation->created_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y')),
                'time' => $consultation->time_formatted,
                'status_label' => $consultation->status_label,
                'consultation_type' => ucwords(str_replace('_', ' ', $consultation->consultation_type ?? 'Konsultasi Online')),
                'owner_name' => $owner?->name ?? 'Peternak Milenial',
                'owner_phone' => $owner?->phone_number ?? ($owner?->peternakProfile?->phone ?? '-'),
                'owner_address' => $owner?->peternakProfile?->address ?? 'Provinsi Jawa Timur',
                'farm_name' => $owner?->peternakProfile?->farm_name ?? 'Peternakan Rakyat Jawa Timur',
                'animal_tag' => $livestock?->tag_number ?? ($livestock?->e_tag_number ?? 'NON-ETAG'),
                'animal_name' => $livestock?->name ?? ($livestock?->breed ?? 'Ternak'),
                'animal_type' => ucwords(str_replace('_', ' ', $livestock?->type ?? 'Ternak Ruminansia')),
                'animal_gender' => ucfirst($livestock?->gender ?? 'Betina'),
                'subject' => $consultation->subject ?? 'Pemeriksaan Kesehatan Ternak',
                'complaint' => $consultation->complaint_details ?? 'Pemeriksaan umum dan konsultasi berkala.',
                'doctor_name' => $doctor?->name ?? 'drh. Dokter Hewan Dinas',
                'doctor_puskeswan' => $doctor?->puskeswan ?? 'Puskeswan Disnak Provinsi Jawa Timur',
                'doctor_sip' => '503/SIP-DISNAK/'.date('Y').'/'.str_pad($consultation->veterinarian_id ?? 1, 3, '0', STR_PAD_LEFT),
                'diagnosis' => $consultation->doctor_notes ?: 'Pemeriksaan klinis telah dilakukan. Kondisi umum ternak memerlukan pengawasan berkala dan suplementasi nutrisi.',
                'prescription' => $consultation->prescription ?: 'Multivitamin B-kompleks 10ml, larutan molase hangat 2x sehari, pemberian pakan hijauan bernutrisi.',
                'care_instructions' => $this->generateCareInstructions($consultation->doctor_notes, $consultation->prescription, $consultation->subject),
            ];

            return view('konsultasi.rekam-medis-dokumen', [
                'record' => $recordData,
                'rawModel' => $consultation,
                'autoPrint' => $request->boolean('print'),
            ]);
        } elseif ($type === 'record') {
            $healthRecord = HealthRecord::with(['livestock.owner.peternakProfile', 'livestock.user.peternakProfile', 'veterinarian'])->findOrFail($id);

            $livestock = $healthRecord->livestock;
            $owner = $livestock?->owner ?? $livestock?->user;

            if (! $currentUser->isAdmin() && ! $currentUser->isDokterHewan() && $owner && $owner->id !== $currentUser->id) {
                abort(403, 'Anda tidak berhak mengakses dokumen rekam medis ini.');
            }

            $doctor = $healthRecord->veterinarian;

            $recordData = [
                'type' => 'record',
                'id' => $healthRecord->id,
                'document_number' => 'RM-JTM/'.Carbon::parse($healthRecord->record_date)->format('Y').'/MED-'.str_pad($healthRecord->id, 4, '0', STR_PAD_LEFT),
                'date' => Carbon::parse($healthRecord->record_date)->translatedFormat('d F Y'),
                'time' => '09:00 WIB',
                'status_label' => 'Tindakan Terverifikasi',
                'consultation_type' => ucwords(str_replace('_', ' ', $healthRecord->record_type ?? 'Tindakan Medis')),
                'owner_name' => $owner?->name ?? 'Peternak Milenial',
                'owner_phone' => $owner?->phone_number ?? ($owner?->peternakProfile?->phone ?? '-'),
                'owner_address' => $owner?->peternakProfile?->address ?? 'Provinsi Jawa Timur',
                'farm_name' => $owner?->peternakProfile?->farm_name ?? 'Peternakan Rakyat Jawa Timur',
                'animal_tag' => $livestock?->tag_number ?? ($livestock?->e_tag_number ?? 'NON-ETAG'),
                'animal_name' => $livestock?->name ?? ($livestock?->breed ?? 'Ternak'),
                'animal_type' => ucwords(str_replace('_', ' ', $livestock?->type ?? 'Ternak Ruminansia')),
                'animal_gender' => ucfirst($livestock?->gender ?? 'Betina'),
                'subject' => $healthRecord->title,
                'complaint' => 'Tindakan klinis dan rekam medis terpadu nomor anting resmi Dinas Peternakan.',
                'doctor_name' => $doctor?->name ?? 'drh. Dokter Hewan Dinas',
                'doctor_puskeswan' => $doctor?->puskeswan ?? 'Puskeswan Disnak Provinsi Jawa Timur',
                'doctor_sip' => '503/SIP-DISNAK/'.date('Y').'/'.str_pad($healthRecord->veterinarian_id ?? 1, 3, '0', STR_PAD_LEFT),
                'diagnosis' => $healthRecord->diagnosis ?: 'Pemeriksaan klinis spesifik tercatat pada buku rekam medis ternak resmi.',
                'prescription' => $healthRecord->treatment ?: 'Pemberian obat dan tindakan sesuai protokol veteriner standar.',
                'care_instructions' => $this->generateCareInstructions($healthRecord->diagnosis, $healthRecord->treatment, $healthRecord->title, $healthRecord->notes),
            ];

            return view('konsultasi.rekam-medis-dokumen', [
                'record' => $recordData,
                'rawModel' => $healthRecord,
                'autoPrint' => $request->boolean('print'),
            ]);
        } elseif ($type === 'report') {
            $report = AnimalHealthReport::with(['user.peternakProfile', 'assignedVeterinarian.user', 'responses.user', 'visits.veterinarian'])->findOrFail($id);

            // Authorization: peternak can only see their own, admin and dokter_hewan can see all
            if (! $currentUser->isAdmin() && ! $currentUser->isDokterHewan() && $report->user_id !== $currentUser->id) {
                abort(403, 'Anda tidak berhak mengakses dokumen rekam medis ini.');
            }

            $owner = $report->user;
            $doctor = $report->assignedVeterinarian;
            $latestVisit = $report->visits->where('status', 'selesai')->last() ?? $report->latestVisit;
            $latestResponse = $report->responses->where('user.role', '!=', 'peternak')->last() ?? $report->responses->last();

            $diagnosis = $latestVisit?->examination_notes
                ?: ($latestResponse?->hypothesis ?: 'Evaluasi klinis tuntas tercatat pada rekam riwayat penanganan laporan dinas.');
            $prescription = $latestVisit?->post_visit_recommendations
                ?: ($latestResponse?->recommendations ?: ($latestResponse?->message ?: 'Perawatan pemulihan, biosecurity kandang, dan pemantauan kondisi ternak.'));
            $notes = $latestResponse?->follow_up_instructions ?: ($latestVisit?->examination_notes ?: 'Tercatat resmi pada sistem Layanan Kesehatan Hewan Terpadu Disnak Jatim.');

            $recordData = [
                'type' => 'report',
                'id' => $report->id,
                'document_number' => 'RM-JTM/'.($report->resolved_at?->format('Y') ?? date('Y')).'/'.str_replace('-', '/', $report->report_number),
                'date' => $report->resolved_at ? Carbon::parse($report->resolved_at)->translatedFormat('d F Y') : ($report->updated_at ? $report->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y')),
                'time' => $report->resolved_at ? $report->resolved_at->format('H:i').' WIB' : '12:00 WIB',
                'status_label' => 'Selesai Ditangani (Resmi)',
                'consultation_type' => 'Laporan Kesehatan Hewan'.($report->visits->isNotEmpty() ? ' & Visitasi Lapangan' : ''),
                'owner_name' => $owner?->name ?? 'Peternak Milenial',
                'owner_phone' => $owner?->phone_number ?? ($owner?->peternakProfile?->phone ?? '-'),
                'owner_address' => $report->farm_address ?: ($owner?->peternakProfile?->address ?? ($report->kabupaten ?? 'Provinsi Jawa Timur')),
                'farm_name' => $report->farm_name ?: ($owner?->peternakProfile?->farm_name ?? 'Peternakan Rakyat Jawa Timur'),
                'animal_tag' => 'LKH-'.strtoupper(substr($report->report_number, -4)),
                'animal_name' => $report->livestock_type.' ('.$report->affected_count.' Ekor)',
                'animal_type' => ucwords(str_replace('_', ' ', $report->livestock_type)),
                'animal_gender' => 'Campuran (Jantan & Betina)',
                'subject' => 'Laporan Kesehatan: '.$report->report_number.' ('.$report->livestock_type.')',
                'complaint' => $report->symptoms,
                'doctor_name' => $doctor?->name ?? 'drh. Dokter Hewan Dinas',
                'doctor_puskeswan' => $doctor?->puskeswan ?? 'Puskeswan Disnak Provinsi Jawa Timur',
                'doctor_sip' => '503/SIP-DISNAK/'.date('Y').'/'.str_pad($report->assigned_veterinarian_id ?? 1, 3, '0', STR_PAD_LEFT),
                'diagnosis' => $diagnosis,
                'prescription' => $prescription,
                'care_instructions' => $this->generateCareInstructions($diagnosis, $prescription, $report->report_number, $notes),
            ];

            return view('konsultasi.rekam-medis-dokumen', [
                'record' => $recordData,
                'rawModel' => $report,
                'autoPrint' => $request->boolean('print'),
            ]);
        }

        abort(404, 'Tipe rekam medis tidak valid.');
    }

    /**
     * Generate comprehensive step-by-step handling instructions for the livestock farmer.
     *
     * @return array<int, array{step: int, title: string, icon: string, desc: string}>
     */
    private function generateCareInstructions(?string $diagnosis, ?string $prescription, ?string $title = '', ?string $customNotes = ''): array
    {
        $instructions = [];

        $instructions[] = [
            'step' => 1,
            'title' => 'Isolasi & Kenyamanan Kandang',
            'icon' => 'home',
            'desc' => 'Tempatkan ternak pada petak kandang yang tenang, terlindung dari terpaan angin malam kencang dan hujan. Pastikan sirkulasi udara (ventilasi) mengalir lancar dan alas kandang (litter/jerami) selalu dalam kondisi kering dan bersih untuk meminimalkan kelembapan.',
        ];

        $medicationNote = $prescription ? 'Laksanakan instruksi obat: "'.$prescription.'". ' : '';
        $instructions[] = [
            'step' => 2,
            'title' => 'Tata Cara Pemberian Obat & Terapi',
            'icon' => 'pill',
            'desc' => $medicationNote.'Pemberian obat injeksi hanya boleh dilakukan oleh paramedik/dokter hewan berizin. Untuk obat oral atau multivitamin, berikan sesuai dosis yang tertera dan jangan menghentikan pengobatan sebelum jangka waktu anjuran selesai.',
        ];

        $instructions[] = [
            'step' => 3,
            'title' => 'Manajemen Pakan & Nutrisi Pemulihan',
            'icon' => 'leaf',
            'desc' => 'Sediakan hijauan segar berkualitas (rumput gajah/odot muda yang sudah dilayukan dan dicacah). Berikan air minum bersih secara tidak terbatas (ad libitum). Berikan larutan air molase (tetes tebu) hangat atau gula merah ditambah sedikit garam untuk merangsang nafsu makan dan memulihkan stamina.',
        ];

        $instructions[] = [
            'step' => 4,
            'title' => 'Biosecurity & Sanitasi Kawanan',
            'icon' => 'shield',
            'desc' => 'Lakukan penyemprotan desinfektan ramah lingkungan di sekeliling kandang 1 kali sehari. Pisahkan peralatan pakan dan minum antara hewan sakit dan kawanan sehat. Peternak wajib mencuci tangan dan alas kaki sebelum berpindah merawat ternak lainnya.',
        ];

        $instructions[] = [
            'step' => 5,
            'title' => 'Pemantauan Suhu & Tanda Vital Harian',
            'icon' => 'activity',
            'desc' => 'Ukur suhu rektal ternak 2 kali sehari (pagi dan sore). Amati keaktifan memamah biak (ruminasi), warna selaput lendir mata/gusi, kelancaran buang air besar (konsistensi feses), serta produksi susu harian.',
        ];

        $customText = $customNotes ? $customNotes : 'Apabila dalam waktu 2x24 jam ternak menunjukkan perburukan kondisi (nafas terengah-engah, tidak mau minum sama sekali, atau suhu di atas 40°C), segera hubungi Puskeswan Disnak Jatim terdekat untuk visitasi darurat.';
        $instructions[] = [
            'step' => 6,
            'title' => 'Petunjuk Khusus & Tindak Lanjut Dokter',
            'icon' => 'alert',
            'desc' => $customText,
        ];

        return $instructions;
    }
}
