<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportResponse;
use App\Models\AnimalHealthReportVisit;
use App\Models\Consultation;
use App\Models\ConsultationSchedule;
use App\Models\HealthRecord;
use App\Models\Veterinarian;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VeterinarianScheduleController extends Controller
{
    /**
     * Display the veterinarian's schedule & quota management page.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $currentVet = $user?->veterinarianProfile
            ?? Veterinarian::where('user_id', $user?->id)->first()
            ?? Veterinarian::first();

        if (! $currentVet) {
            abort(403, 'Profil Dokter Hewan tidak ditemukan untuk akun ini.');
        }

        $selectedDate = $request->query('date', now()->toDateString());
        $bookingTab = $request->query('booking_tab', 'semua');

        // Statistics
        $today = now()->toDateString();
        $stats = [
            'total_slots_today' => ConsultationSchedule::where('veterinarian_id', $currentVet->id)
                ->whereDate('date', $today)
                ->count(),
            'total_quota_today' => (int) ConsultationSchedule::where('veterinarian_id', $currentVet->id)
                ->whereDate('date', $today)
                ->where('status', 'buka')
                ->sum('quota'),
            'booked_today' => Consultation::where('veterinarian_id', $user?->id ?? $currentVet->user_id)
                ->whereDate('consultation_date', $today)
                ->where('status', '!=', 'dibatalkan')
                ->count(),
            'completed_count' => Consultation::where(function ($q) use ($user, $currentVet) {
                if ($user) {
                    $q->where('veterinarian_id', $user->id);
                }
                if ($currentVet->user_id) {
                    $q->orWhere('veterinarian_id', $currentVet->user_id);
                }
                $q->orWhereHas('schedule', function ($sq) use ($currentVet) {
                    $sq->where('veterinarian_id', $currentVet->id);
                });
            })
                ->where('status', 'selesai')
                ->count(),
        ];

        // Doctor's consultation slots
        $schedulesQuery = ConsultationSchedule::where('veterinarian_id', $currentVet->id)
            ->with(['consultations.user.peternakProfile', 'consultations.livestock'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc');

        if ($request->filled('filter_date')) {
            $schedulesQuery->whereDate('date', $request->query('filter_date'));
        }

        $schedules = $schedulesQuery->paginate(15)->withQueryString();

        // Peternak Bookings / Reservations
        $bookingsQuery = Consultation::where(function ($q) use ($user, $currentVet) {
            if ($user) {
                $q->where('veterinarian_id', $user->id);
            }
            if ($currentVet->user_id) {
                $q->orWhere('veterinarian_id', $currentVet->user_id);
            }
            $q->orWhereHas('schedule', function ($sq) use ($currentVet) {
                $sq->where('veterinarian_id', $currentVet->id);
            });
        })
            ->with(['user.peternakProfile', 'livestock', 'schedule'])
            ->latest('consultation_date')
            ->latest('id');

        if ($bookingTab === 'menunggu') {
            $bookingsQuery->where('status', 'menunggu_konfirmasi');
        } elseif ($bookingTab === 'dikonfirmasi') {
            $bookingsQuery->where('status', 'dikonfirmasi');
        } elseif ($bookingTab === 'selesai') {
            $bookingsQuery->where('status', 'selesai');
        } elseif ($bookingTab === 'dibatalkan') {
            $bookingsQuery->where('status', 'dibatalkan');
        }

        $bookings = $bookingsQuery->paginate(10, ['*'], 'bookings_page')->withQueryString();

        // Riwayat Rekam Medis & Riwayat Pemeriksaan Selesai (Tempat Berbeda & Terpisah)
        $filterRmDate = $request->query('filter_rm_date') ?? $request->query('rm_date');
        $searchRm = $request->query('search_rm');

        $completedQuery = Consultation::where(function ($q) use ($user, $currentVet) {
            if ($user) {
                $q->where('veterinarian_id', $user->id);
            }
            if ($currentVet->user_id) {
                $q->orWhere('veterinarian_id', $currentVet->user_id);
            }
            $q->orWhereHas('schedule', function ($sq) use ($currentVet) {
                $sq->where('veterinarian_id', $currentVet->id);
            });
        })
            ->where('status', 'selesai')
            ->with(['user.peternakProfile', 'livestock', 'schedule', 'veterinarian']);

        if (! empty($filterRmDate)) {
            $completedQuery->where(function ($q) use ($filterRmDate) {
                $q->whereDate('consultation_date', $filterRmDate)
                    ->orWhereHas('schedule', function ($sq) use ($filterRmDate) {
                        $sq->whereDate('date', $filterRmDate);
                    })
                    ->orWhereDate('updated_at', $filterRmDate);
            });
        }

        if (! empty($searchRm)) {
            $completedQuery->where(function ($q) use ($searchRm) {
                $q->where('booking_code', 'like', "%{$searchRm}%")
                    ->orWhere('subject', 'like', "%{$searchRm}%")
                    ->orWhere('doctor_notes', 'like', "%{$searchRm}%")
                    ->orWhere('prescription', 'like', "%{$searchRm}%")
                    ->orWhereHas('user', function ($uq) use ($searchRm) {
                        $uq->where('name', 'like', "%{$searchRm}%");
                    })
                    ->orWhereHas('livestock', function ($lq) use ($searchRm) {
                        $lq->where('name', 'like', "%{$searchRm}%")
                            ->orWhere('tag_number', 'like', "%{$searchRm}%")
                            ->orWhere('type', 'like', "%{$searchRm}%");
                    });
            });
        }

        $completedConsultations = $completedQuery->latest('updated_at')->paginate(8, ['*'], 'rm_page')->withQueryString();

        // Available dates for quick filter chips
        $availableRmDates = Consultation::where(function ($q) use ($user, $currentVet) {
            if ($user) {
                $q->where('veterinarian_id', $user->id);
            }
            if ($currentVet->user_id) {
                $q->orWhere('veterinarian_id', $currentVet->user_id);
            }
            $q->orWhereHas('schedule', function ($sq) use ($currentVet) {
                $sq->where('veterinarian_id', $currentVet->id);
            });
        })
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->take(30)
            ->get()
            ->map(function ($c) {
                $d = $c->schedule?->date
                    ? Carbon::parse($c->schedule->date)
                    : ($c->consultation_date ? Carbon::parse($c->consultation_date) : $c->updated_at);

                return [
                    'iso' => $d->toDateString(),
                    'label' => $d->translatedFormat('d M Y'),
                ];
            })
            ->unique('iso')
            ->values();

        // Active Navbar Tab: 'slot' (Daftar Slot Jam Layanan) vs 'rekam_medis'/'laporan_kesehatan' (Riwayat Laporan Kesehatan)
        $activeTab = $request->query('tab');
        if ($activeTab === 'laporan_kesehatan') {
            $activeTab = 'rekam_medis';
        }
        if (empty($activeTab) || ! in_array($activeTab, ['slot', 'rekam_medis'])) {
            if ($request->filled('filter_rm_date') || $request->filled('search_rm')) {
                $activeTab = 'rekam_medis';
            } else {
                $activeTab = 'slot';
            }
        }

        return view('dokter-hewan.jadwal', [
            'currentVet' => $currentVet,
            'stats' => $stats,
            'schedules' => $schedules,
            'bookings' => $bookings,
            'selectedDate' => $selectedDate,
            'bookingTab' => $bookingTab,
            'activeTab' => $activeTab,
            'completedConsultations' => $completedConsultations,
            'filterRmDate' => $filterRmDate,
            'searchRm' => $searchRm,
            'availableRmDates' => $availableRmDates,
        ]);
    }

    /**
     * Store a new consultation slot with quota (Doctor).
     */
    public function storeSlot(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $currentVet = $user?->veterinarianProfile
            ?? Veterinarian::where('user_id', $user?->id)->first()
            ?? Veterinarian::first();

        if (! $currentVet) {
            abort(403, 'Akses terbatas untuk Dokter Hewan.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'start_time' => ['required', 'string', 'max:10'],
            'end_time' => ['required', 'string', 'max:10'],
            'quota' => ['required', 'integer', 'min:1', 'max:50'],
            'service_type' => ['nullable', 'in:online,offline,konsultasi_online,telemedisin,tatap_muka,kunjungan,semua'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        ConsultationSchedule::create([
            'veterinarian_id' => $currentVet->id,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'quota' => $validated['quota'],
            'status' => 'buka',
            'service_type' => $validated['service_type'] ?? 'online',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Slot jadwal konsultasi {$validated['start_time']} - {$validated['end_time']} (Kuota: {$validated['quota']} peternak) berhasil dibuat!");
    }

    /**
     * Quick Generator: Create standard daily slots (e.g. 5 hourly slots) for a given date.
     */
    public function generateDailySlots(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $currentVet = $user?->veterinarianProfile
            ?? Veterinarian::where('user_id', $user?->id)->first()
            ?? Veterinarian::first();

        if (! $currentVet) {
            abort(403, 'Akses terbatas untuk Dokter Hewan.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'quota_per_slot' => ['nullable', 'integer', 'min:1', 'max:50'],
            'default_quota' => ['nullable', 'integer', 'min:1', 'max:50'],
            'service_type' => ['nullable', 'in:online,offline,konsultasi_online,telemedisin,tatap_muka,kunjungan,semua'],
        ]);

        $quota = $validated['quota_per_slot'] ?? $validated['default_quota'] ?? 5;
        $serviceType = $validated['service_type'] ?? 'online';

        $slots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['11:00', '12:00'],
            ['12:00', '13:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
        ];

        $createdCount = 0;
        foreach ($slots as [$start, $end]) {
            // Only create if slot doesn't exist yet
            $exists = ConsultationSchedule::where('veterinarian_id', $currentVet->id)
                ->whereDate('date', $validated['date'])
                ->where('start_time', $start)
                ->exists();

            if (! $exists) {
                ConsultationSchedule::create([
                    'veterinarian_id' => $currentVet->id,
                    'date' => $validated['date'],
                    'start_time' => $start,
                    'end_time' => $end,
                    'quota' => $quota,
                    'status' => 'buka',
                    'service_type' => $serviceType,
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "{$createdCount} slot jadwal standar dengan kuota {$quota} peternak/jam berhasil digenerate untuk tanggal {$validated['date']}!");
    }

    /**
     * Toggle open/closed status of a schedule slot.
     */
    public function toggleStatus(ConsultationSchedule $schedule): RedirectResponse
    {
        $newStatus = $schedule->status === 'buka' ? 'tutup' : 'buka';
        $schedule->update(['status' => $newStatus]);

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Status slot jam {$schedule->time_slot_label} berhasil diubah menjadi: ".strtoupper($newStatus));
    }

    /**
     * Update slot quota, time, and notes.
     */
    public function updateSlot(Request $request, ConsultationSchedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'start_time' => ['nullable', 'string', 'max:10'],
            'end_time' => ['nullable', 'string', 'max:10'],
            'quota' => ['required', 'integer', 'min:1', 'max:50'],
            'status' => ['nullable', 'in:buka,tutup'],
            'service_type' => ['nullable', 'in:online,offline,konsultasi_online,telemedisin,tatap_muka,kunjungan,semua'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $updateData = [
            'quota' => $validated['quota'],
            'status' => $validated['status'] ?? $schedule->status,
            'service_type' => $validated['service_type'] ?? $schedule->service_type,
            'notes' => array_key_exists('notes', $validated) ? $validated['notes'] : $schedule->notes,
        ];

        if (! empty($validated['start_time'])) {
            $updateData['start_time'] = $validated['start_time'];
        }

        if (! empty($validated['end_time'])) {
            $updateData['end_time'] = $validated['end_time'];
        }

        $schedule->update($updateData);

        // Update consultation_time in active consultations if time slot changed
        if (! empty($validated['start_time']) || ! empty($validated['end_time'])) {
            $schedule->activeConsultations()->update([
                'consultation_time' => $schedule->time_slot_label,
            ]);
        }

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Data slot jadwal jam {$schedule->time_slot_label} berhasil diperbarui.");
    }

    /**
     * Delete a schedule slot along with any attached bookings.
     */
    public function destroySlot(ConsultationSchedule $schedule): RedirectResponse
    {
        $timeLabel = $schedule->time_slot_label;

        // Mark any consultations attached to this slot as cancelled by doctor and detach slot
        $schedule->consultations()->update([
            'status' => 'dibatalkan',
            'consultation_schedule_id' => null,
            'doctor_notes' => 'Slot jadwal konsultasi telah dihapus oleh dokter hewan. Anda diminta untuk memilih dokter hewan yang baru atau mengatur ulang jadwal konsultasi.',
        ]);
        $schedule->delete();

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Slot jadwal konsultasi {$timeLabel} berhasil dihapus.");
    }

    /**
     * Delete a peternak consultation booking.
     */
    public function destroyBooking(Consultation $consultation): RedirectResponse
    {
        if ($consultation->status === 'selesai') {
            return redirect()->route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis'])
                ->with('error', 'Konsultasi yang telah selesai ditangani tidak dapat dihapus.');
        }

        $bookingCode = $consultation->booking_code ?? ('#CONS-'.$consultation->id);
        $peternakName = $consultation->user?->name ?? 'Peternak';

        $consultation->update([
            'status' => 'dibatalkan',
            'consultation_schedule_id' => null,
            'doctor_notes' => 'Jadwal reservasi konsultasi ini telah dihapus oleh dokter hewan. Anda diminta untuk memilih dokter hewan yang baru atau mengatur ulang jadwal konsultasi.',
        ]);

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Data booking '{$bookingCode}' atas nama {$peternakName} berhasil dihapus dari jadwal.");
    }

    /**
     * Show detailed clinical examination and professional response view for a consultation.
     */
    public function showConsultation(Consultation $consultation): View
    {
        $user = auth()->user();
        $currentVet = $user?->veterinarianProfile
            ?? Veterinarian::where('user_id', $user?->id)->first()
            ?? Veterinarian::first();

        $consultation->load([
            'user.peternakProfile',
            'livestock',
            'schedule',
        ]);

        return view('dokter-hewan.konsultasi-show', [
            'consultation' => $consultation,
            'currentVet' => $currentVet,
        ]);
    }

    /**
     * Store professional response for a consultation session (Formulir Tanggapan & Rekomendasi Profesional).
     */
    public function storeConsultationResponse(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:4000'],
            'doctor_notes' => ['nullable', 'string', 'max:4000'],
            'hypothesis' => ['nullable', 'string', 'max:500'],
            'urgency_level' => ['nullable', 'string', 'in:rendah,sedang,tinggi,darurat'],
            'prescription' => ['nullable', 'string', 'max:4000'],
            'recommendations' => ['nullable', 'string', 'max:4000'],
            'follow_up_instructions' => ['nullable', 'string', 'max:4000'],
            'requires_visit' => ['nullable'],
            'status' => ['required', 'in:dikonfirmasi,sedang_ditangani,selesai,sudah_dijawab,dibatalkan'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'doctor_additional_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $doctorNotes = $validated['message'] ?? $validated['doctor_notes'] ?? $consultation->doctor_notes ?? 'Pemeriksaan klinis dan telemedisin veteriner telah diselesaikan oleh dokter hewan dinas.';
        $prescription = $validated['recommendations'] ?? $validated['prescription'] ?? $consultation->prescription;
        $status = in_array($validated['status'], ['sudah_dijawab', 'selesai']) ? 'selesai' : $validated['status'];
        $requiresVisit = $request->boolean('requires_visit');

        $consultation->update([
            'status' => $status,
            'doctor_notes' => $doctorNotes,
            'hypothesis' => $validated['hypothesis'] ?? $consultation->hypothesis,
            'urgency_level' => $validated['urgency_level'] ?? $consultation->urgency_level ?? 'sedang',
            'prescription' => $prescription,
            'recommendations' => $prescription,
            'follow_up_instructions' => $validated['follow_up_instructions'] ?? $consultation->follow_up_instructions,
            'requires_visit' => $requiresVisit,
            'doctor_additional_notes' => $validated['notes'] ?? $validated['doctor_additional_notes'] ?? $consultation->doctor_additional_notes,
        ]);

        // Synchronize medical consultation response directly to peternak's health report
        $this->syncConsultationToHealthReport(
            consultation: $consultation,
            status: $status,
            doctorNotes: $doctorNotes,
            hypothesis: $validated['hypothesis'] ?? $consultation->hypothesis,
            prescription: $prescription,
            followUpInstructions: $validated['follow_up_instructions'] ?? $consultation->follow_up_instructions,
            urgencyLevel: $validated['urgency_level'] ?? $consultation->urgency_level ?? 'sedang',
            requiresVisit: $requiresVisit,
            doctorAdditionalNotes: $validated['notes'] ?? $validated['doctor_additional_notes'] ?? $consultation->doctor_additional_notes
        );

        // If completed and has livestock, create HealthRecord automatically
        if ($status === 'selesai' && $consultation->livestock_id) {
            HealthRecord::create([
                'livestock_id' => $consultation->livestock_id,
                'veterinarian_id' => auth()->id() ?? $consultation->veterinarian_id,
                'record_type' => 'pemeriksaan',
                'title' => 'Hasil Konsultasi: '.($validated['hypothesis'] ?? $consultation->subject),
                'diagnosis' => $doctorNotes,
                'treatment' => $prescription ?? 'Rekomendasi perawatan terlampir.',
                'record_date' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dokter-hewan.konsultasi.show', $consultation)
            ->with('success', 'Tanggapan profesional dokter berhasil disimpan dan sesi konsultasi telah diperbarui.');
    }

    /**
     * Update status and audit note directly for a consultation.
     */
    public function updateQuickStatus(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:dikonfirmasi,sedang_ditangani,selesai,dibatalkan'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $consultation->update([
            'status' => $validated['status'],
            'doctor_additional_notes' => $validated['notes'] ?: $consultation->doctor_additional_notes,
        ]);

        // Sync status with Peternak's Health Report
        $this->syncConsultationToHealthReport(
            consultation: $consultation,
            status: $validated['status'],
            doctorNotes: $consultation->doctor_notes,
            hypothesis: $consultation->hypothesis,
            prescription: $consultation->prescription,
            followUpInstructions: $consultation->follow_up_instructions,
            urgencyLevel: $consultation->urgency_level ?? 'sedang',
            requiresVisit: (bool) $consultation->requires_visit,
            doctorAdditionalNotes: $validated['notes'] ?: $consultation->doctor_additional_notes
        );

        return redirect()->back()
            ->with('success', "Status konsultasi '{$consultation->booking_code}' berhasil diperbarui menjadi: ".$consultation->status_label);
    }

    /**
     * Update peternak consultation booking status (confirm, complete, or cancel).
     */
    public function updateBookingStatus(Request $request, Consultation $consultation): RedirectResponse
    {
        if ($consultation->status === 'selesai') {
            return redirect()->route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis'])
                ->with('error', 'Konsultasi ini telah selesai ditangani. Catatan diagnosis dan resep obat telah dikunci dan tidak dapat diedit kembali.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:dikonfirmasi,sedang_ditangani,selesai,sudah_dijawab,dibatalkan'],
            'doctor_notes' => ['nullable', 'string', 'max:4000'],
            'message' => ['nullable', 'string', 'max:4000'],
            'hypothesis' => ['nullable', 'string', 'max:500'],
            'urgency_level' => ['nullable', 'string', 'in:rendah,sedang,tinggi,darurat'],
            'prescription' => ['nullable', 'string', 'max:4000'],
            'recommendations' => ['nullable', 'string', 'max:4000'],
            'follow_up_instructions' => ['nullable', 'string', 'max:4000'],
            'requires_visit' => ['nullable'],
            'doctor_additional_notes' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $status = in_array($validated['status'], ['sudah_dijawab', 'selesai']) ? 'selesai' : $validated['status'];
        $doctorNotes = $validated['message'] ?? $validated['doctor_notes'] ?? ($consultation->doctor_notes ?: ($status === 'selesai' ? 'Pemeriksaan telemedisin selesai ditangani.' : null));
        if ($validated['status'] === 'dibatalkan' && empty($doctorNotes)) {
            $doctorNotes = 'Jadwal reservasi konsultasi ini telah dibatalkan oleh dokter hewan. Anda diminta untuk memilih dokter hewan yang baru atau mengatur ulang jadwal konsultasi.';
        }

        $prescription = $validated['recommendations'] ?? $validated['prescription'] ?? $consultation->prescription;
        $requiresVisit = $request->boolean('requires_visit');

        $consultation->update([
            'status' => $status,
            'consultation_schedule_id' => $status === 'dibatalkan' ? null : $consultation->consultation_schedule_id,
            'doctor_notes' => $doctorNotes,
            'hypothesis' => $validated['hypothesis'] ?? $consultation->hypothesis,
            'urgency_level' => $validated['urgency_level'] ?? $consultation->urgency_level ?? 'sedang',
            'prescription' => $prescription,
            'recommendations' => $prescription,
            'follow_up_instructions' => $validated['follow_up_instructions'] ?? $consultation->follow_up_instructions,
            'requires_visit' => $requiresVisit,
            'doctor_additional_notes' => $validated['notes'] ?? $validated['doctor_additional_notes'] ?? $consultation->doctor_additional_notes,
        ]);

        // Synchronize medical consultation response directly to peternak's health report
        $this->syncConsultationToHealthReport(
            consultation: $consultation,
            status: $status,
            doctorNotes: $doctorNotes,
            hypothesis: $validated['hypothesis'] ?? $consultation->hypothesis,
            prescription: $prescription,
            followUpInstructions: $validated['follow_up_instructions'] ?? $consultation->follow_up_instructions,
            urgencyLevel: $validated['urgency_level'] ?? $consultation->urgency_level ?? 'sedang',
            requiresVisit: $requiresVisit,
            doctorAdditionalNotes: $validated['notes'] ?? $validated['doctor_additional_notes'] ?? $consultation->doctor_additional_notes
        );

        // If completed and has livestock, create HealthRecord automatically
        if ($status === 'selesai' && $consultation->livestock_id) {
            HealthRecord::create([
                'livestock_id' => $consultation->livestock_id,
                'veterinarian_id' => auth()->id() ?? $consultation->veterinarian_id,
                'record_type' => 'pemeriksaan',
                'title' => 'Hasil Konsultasi Medis: '.$consultation->subject,
                'diagnosis' => $doctorNotes ?? 'Pemeriksaan telemedisin selesai.',
                'treatment' => $prescription ?? 'Rekomendasi perawatan terlampir.',
                'record_date' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dokter-hewan.jadwal.index', ['tab' => $status === 'selesai' ? 'rekam_medis' : 'slot'])
            ->with('success', "Status reservasi '{$consultation->booking_code}' berhasil diperbarui menjadi: ".$consultation->status_label);
    }

    /**
     * Synchronize consultation examination and professional response to Peternak's AnimalHealthReport.
     */
    protected function syncConsultationToHealthReport(
        Consultation $consultation,
        string $status,
        ?string $doctorNotes = null,
        ?string $hypothesis = null,
        ?string $prescription = null,
        ?string $followUpInstructions = null,
        ?string $urgencyLevel = null,
        bool $requiresVisit = false,
        ?string $doctorAdditionalNotes = null
    ): ?AnimalHealthReport {
        $doctorUser = auth()->user() ?? $consultation->veterinarian;
        $doctorUserId = $doctorUser?->id ?? $consultation->veterinarian_id;
        $currentVet = $doctorUser?->veterinarianProfile
            ?? Veterinarian::where('user_id', $doctorUserId)->first()
            ?? Veterinarian::first();

        // 1. Find existing linked report or active report for this peternak
        $report = null;
        if ($consultation->animal_health_report_id) {
            $report = AnimalHealthReport::find($consultation->animal_health_report_id);
        }

        if (! $report) {
            $report = AnimalHealthReport::where('consultation_id', $consultation->id)->first();
        }

        if (! $report) {
            $report = AnimalHealthReport::where('user_id', $consultation->user_id)
                ->whereIn('status', ['menunggu_respons', 'menunggu_penugasan', 'sedang_ditangani', 'sudah_dijawab'])
                ->latest()
                ->first();
        }

        // 2. If no open report found, create a new AnimalHealthReport for this peternak
        if (! $report) {
            $livestock = $consultation->livestock;
            $user = $consultation->user;
            $reportNumber = AnimalHealthReport::generateReportNumber();

            $report = AnimalHealthReport::create([
                'report_number' => $reportNumber,
                'user_id' => $consultation->user_id,
                'assigned_veterinarian_id' => $currentVet?->id,
                'consultation_id' => $consultation->id,
                'livestock_type' => $livestock?->type ?? ($livestock?->breed ?? 'Hewan Ternak'),
                'affected_count' => 1,
                'symptoms' => $consultation->complaint_details ?: ($consultation->subject ?: 'Konsultasi Pemeriksaan Kesehatan Hewan'),
                'symptoms_started_at' => $consultation->consultation_date ?: now()->toDateString(),
                'urgency' => in_array($urgencyLevel, ['rendah', 'sedang', 'tinggi', 'kritis']) ? $urgencyLevel : 'sedang',
                'farm_name' => $user?->peternakProfile?->farm_name ?? ('Peternakan '.($user?->name ?? 'Peternak')),
                'farm_address' => $user?->alamat ?? ($user?->peternakProfile?->address ?? null),
                'kabupaten' => $user?->kabupaten ?? 'Jawa Timur',
                'status' => 'menunggu_respons',
            ]);
        }

        // Link both ways
        if ($consultation->animal_health_report_id !== $report->id) {
            $consultation->updateQuietly(['animal_health_report_id' => $report->id]);
        }
        if ($report->consultation_id !== $consultation->id) {
            $report->updateQuietly(['consultation_id' => $consultation->id]);
        }

        // 3. Update Report Status & Doctor Assignment
        $previousStatus = $report->status;
        $reportStatus = match ($status) {
            'selesai', 'sudah_dijawab' => 'selesai',
            'sedang_ditangani' => 'sedang_ditangani',
            'dikonfirmasi' => 'sedang_ditangani',
            'dibatalkan' => ($report->status === 'menunggu_respons' ? 'menunggu_respons' : $report->status),
            default => $report->status,
        };

        $reportUpdate = [
            'status' => $reportStatus,
            'assigned_veterinarian_id' => $report->assigned_veterinarian_id ?: $currentVet?->id,
            'last_responded_at' => now(),
        ];

        if ($reportStatus === 'selesai') {
            $reportUpdate['resolved_at'] = $report->resolved_at ?: now();
        }

        $report->update($reportUpdate);

        // 4. Record/Update AnimalHealthReportResponse
        if (! empty($doctorNotes) || ! empty($prescription) || ! empty($hypothesis)) {
            $existingResponse = AnimalHealthReportResponse::where('animal_health_report_id', $report->id)
                ->where('user_id', $doctorUserId)
                ->latest()
                ->first();

            $responseData = [
                'animal_health_report_id' => $report->id,
                'user_id' => $doctorUserId,
                'message' => $doctorNotes ?: 'Pemeriksaan telemedisin dan konsultasi kesehatan ternak telah diselesaikan oleh dokter hewan dinas.',
                'hypothesis' => $hypothesis ?: $report->symptoms,
                'recommendations' => $prescription,
                'follow_up_instructions' => $followUpInstructions,
                'urgency_level' => $urgencyLevel ?: 'sedang',
                'requires_visit' => $requiresVisit,
                'notes' => $doctorAdditionalNotes,
            ];

            if ($existingResponse) {
                $existingResponse->update($responseData);
            } else {
                AnimalHealthReportResponse::create($responseData);
            }
        }

        // 5. If requires visit, create AnimalHealthReportVisit
        if ($requiresVisit) {
            $existingVisit = AnimalHealthReportVisit::where('animal_health_report_id', $report->id)->first();
            if (! $existingVisit) {
                AnimalHealthReportVisit::create([
                    'animal_health_report_id' => $report->id,
                    'veterinarian_id' => $currentVet?->id,
                    'created_by_id' => $doctorUserId,
                    'visit_reason' => 'Kasus ini memerlukan Kunjungan Langsung ke Lokasi Peternakan oleh tim veteriner lapangan hasil evaluasi konsultasi.',
                    'proposed_date' => now()->addDay()->setTime(9, 0),
                    'status' => 'menunggu_konfirmasi',
                ]);
            }
        }

        // 6. Audit Trail Status History
        if ($previousStatus !== $reportStatus) {
            $report->statusHistories()->create([
                'changed_by_id' => $doctorUserId,
                'previous_status' => $previousStatus,
                'new_status' => $reportStatus,
                'notes' => "Status laporan diselaraskan dari sesi konsultasi {$consultation->booking_code} (".($status === 'selesai' ? 'Selesai Ditangani' : ucfirst($status)).').',
            ]);
        }

        return $report;
    }
}
