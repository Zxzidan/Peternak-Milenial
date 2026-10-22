<?php

namespace App\Http\Controllers;

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

        // Active Navbar Tab: 'slot' (Daftar Slot Jam Layanan) vs 'rekam_medis' (Riwayat Pemeriksaan & Rekam Medis)
        $activeTab = $request->query('tab');
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
     * Update peternak consultation booking status (confirm, complete, or cancel).
     */
    public function updateBookingStatus(Request $request, Consultation $consultation): RedirectResponse
    {
        if ($consultation->status === 'selesai') {
            return redirect()->route('dokter-hewan.jadwal.index', ['tab' => 'rekam_medis'])
                ->with('error', 'Konsultasi ini telah selesai ditangani. Catatan diagnosis dan resep obat telah dikunci dan tidak dapat diedit kembali.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:dikonfirmasi,selesai,dibatalkan'],
            'doctor_notes' => ['nullable', 'string', 'max:2000'],
            'prescription' => ['nullable', 'string', 'max:2000'],
        ]);

        $doctorNotes = $validated['doctor_notes'] ?? $consultation->doctor_notes;
        if ($validated['status'] === 'dibatalkan' && empty($doctorNotes)) {
            $doctorNotes = 'Jadwal reservasi konsultasi ini telah dibatalkan oleh dokter hewan. Anda diminta untuk memilih dokter hewan yang baru atau mengatur ulang jadwal konsultasi.';
        }

        $consultation->update([
            'status' => $validated['status'],
            'consultation_schedule_id' => $validated['status'] === 'dibatalkan' ? null : $consultation->consultation_schedule_id,
            'doctor_notes' => $doctorNotes,
            'prescription' => $validated['prescription'] ?? $consultation->prescription,
        ]);

        // If completed and has livestock, create HealthRecord automatically
        if ($validated['status'] === 'selesai' && $consultation->livestock_id) {
            HealthRecord::create([
                'livestock_id' => $consultation->livestock_id,
                'veterinarian_id' => auth()->id() ?? $consultation->veterinarian_id,
                'record_type' => 'pemeriksaan',
                'title' => 'Hasil Konsultasi Medis: '.$consultation->subject,
                'diagnosis' => $validated['doctor_notes'] ?? 'Pemeriksaan telemedisin selesai.',
                'treatment' => $validated['prescription'] ?? 'Rekomendasi perawatan terlampir.',
                'record_date' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dokter-hewan.jadwal.index')
            ->with('success', "Status reservasi '{$consultation->booking_code}' berhasil diperbarui menjadi: ".$consultation->status_label);
    }
}
