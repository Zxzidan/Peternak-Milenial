<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportResponse;
use App\Models\AnimalHealthReportVisit;
use App\Models\Veterinarian;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeterinarianDashboardController extends Controller
{
    /**
     * Display the veterinarian dashboard with statistics and reports list.
     */
    public function index(Request $request): View
    {
        $currentVet = auth()->user()?->veterinarianProfile;

        // Statistics (100% real-time from DB)
        $stats = [
            'laporan_masuk' => AnimalHealthReport::where('status', 'menunggu_respons')->count(),
            'sedang_ditangani' => AnimalHealthReport::where('status', 'sedang_ditangani')->count(),
            'sudah_dijawab' => AnimalHealthReport::where('status', 'sudah_dijawab')->count(),
            'perlu_kunjungan' => AnimalHealthReport::whereIn('status', ['menunggu_kunjungan', 'kunjungan_terjadwal'])->count(),
            'selesai' => AnimalHealthReport::where('status', 'selesai')->count(),
            'total' => AnimalHealthReport::count(),
        ];

        $tab = $request->query('tab', 'semua');
        $search = $request->query('search');

        $query = AnimalHealthReport::with(['user', 'assignedVeterinarian', 'latestVisit'])
            ->latest();

        // Apply Tab Filter
        if ($tab === 'masuk') {
            $query->where('status', 'menunggu_respons');
        } elseif ($tab === 'ditangani') {
            $query->where('status', 'sedang_ditangani');
        } elseif ($tab === 'dijawab') {
            $query->where('status', 'sudah_dijawab');
        } elseif ($tab === 'kunjungan') {
            $query->whereIn('status', ['menunggu_kunjungan', 'kunjungan_terjadwal']);
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        }

        // Apply Search (Nomor laporan, nama peternak, lokasi/kabupaten, jenis hewan)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%{$search}%")
                    ->orWhere('livestock_type', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('farm_name', 'like', "%{$search}%")
                    ->orWhere('farm_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    });
            });
        }

        $reports = $query->paginate(10)->withQueryString();

        return view('dokter-hewan.dashboard', [
            'stats' => $stats,
            'reports' => $reports,
            'currentTab' => $tab,
            'search' => $search,
            'currentVet' => $currentVet,
        ]);
    }

    /**
     * Show detailed inspection view of a single health report.
     */
    public function show(AnimalHealthReport $report): View
    {
        $report->load([
            'user.peternakProfile',
            'assignedVeterinarian',
            'responses.user',
            'visits.veterinarian',
            'statusHistories.changer',
        ]);

        $currentVet = auth()->user()?->veterinarianProfile;

        return view('dokter-hewan.show', [
            'report' => $report,
            'currentVet' => $currentVet,
        ]);
    }

    /**
     * Store initial or follow-up professional response from veterinarian.
     */
    public function storeResponse(Request $request, AnimalHealthReport $report): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'message' => ['required', 'string'],
            'hypothesis' => ['nullable', 'string'],
            'recommendations' => ['nullable', 'string'],
            'follow_up_instructions' => ['nullable', 'string'],
            'urgency_level' => ['nullable', 'in:rendah,sedang,tinggi,kritis'],
            'requires_visit' => ['nullable', 'boolean'],
            'target_status' => ['required', 'in:sudah_dijawab,sedang_ditangani,menunggu_kunjungan,menunggu_tindak_lanjut'],
            'notes' => ['nullable', 'string'],
        ], [
            'message.required' => 'Pesan tanggapan dan analisis profesional wajib diisi.',
            'target_status.required' => 'Status pembaruan laporan wajib dipilih.',
        ]);

        $requiresVisit = $request->boolean('requires_visit');
        $targetStatus = $requiresVisit ? 'menunggu_kunjungan' : $validated['target_status'];

        DB::transaction(function () use ($report, $user, $validated, $requiresVisit, $targetStatus) {
            // Assign current vet if not assigned yet
            $vet = $user->veterinarianProfile;
            if ($vet && ! $report->assigned_veterinarian_id) {
                $report->assigned_veterinarian_id = $vet->id;
            }

            // Save Response
            AnimalHealthReportResponse::create([
                'animal_health_report_id' => $report->id,
                'user_id' => $user->id,
                'message' => $validated['message'],
                'hypothesis' => $validated['hypothesis'] ?? null,
                'recommendations' => $validated['recommendations'] ?? null,
                'follow_up_instructions' => $validated['follow_up_instructions'] ?? null,
                'urgency_level' => $validated['urgency_level'] ?? null,
                'requires_visit' => $requiresVisit,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Update Report Status
            $report->last_responded_at = now();
            $report->transitionTo(
                $targetStatus,
                $user->id,
                "Tanggapan dikirim oleh Drh. {$user->name}. Dugaan awal: ".($validated['hypothesis'] ?? 'Evaluasi klinis berjalan')
            );
        });

        return redirect()->route('dokter-hewan.show', $report)
            ->with('success', 'Tanggapan dan rekomendasi profesional berhasil dikirim ke peternak.');
    }

    /**
     * Propose an in-person field visit to the livestock farm.
     */
    public function proposeVisit(Request $request, AnimalHealthReport $report): RedirectResponse
    {
        $user = auth()->user();
        $vet = $user->veterinarianProfile ?? Veterinarian::first();

        $validated = $request->validate([
            'visit_reason' => ['required', 'string'],
            'proposed_date' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string'],
        ], [
            'visit_reason.required' => 'Alasan perlunya kunjungan lapangan wajib diisi.',
            'proposed_date.required' => 'Usulan tanggal dan jam kunjungan wajib ditentukan.',
            'proposed_date.after' => 'Jadwal kunjungan harus di masa yang akan datang.',
        ]);

        DB::transaction(function () use ($report, $user, $vet, $validated) {
            if ($vet && ! $report->assigned_veterinarian_id) {
                $report->assigned_veterinarian_id = $vet->id;
                $report->save();
            }

            AnimalHealthReportVisit::create([
                'animal_health_report_id' => $report->id,
                'veterinarian_id' => $vet?->id,
                'created_by_id' => $user->id,
                'visit_reason' => $validated['visit_reason'],
                'proposed_date' => $validated['proposed_date'],
                'status' => 'menunggu_konfirmasi',
            ]);

            $report->transitionTo(
                'menunggu_kunjungan',
                $user->id,
                "Jadwal kunjungan lapangan diusulkan untuk: {$validated['proposed_date']}. Menunggu konfirmasi peternak."
            );
        });

        return redirect()->route('dokter-hewan.show', $report)
            ->with('success', 'Usulan jadwal kunjungan lapangan berhasil diajukan kepada peternak.');
    }

    /**
     * Record examination results and post-visit findings.
     */
    public function recordVisitResult(Request $request, AnimalHealthReport $report, AnimalHealthReportVisit $visit): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'examination_notes' => ['required', 'string'],
            'post_visit_recommendations' => ['nullable', 'string'],
            'next_report_status' => ['required', 'in:menunggu_tindak_lanjut,selesai'],
        ], [
            'examination_notes.required' => 'Catatan dan hasil pemeriksaan lapangan wajib diisi.',
            'next_report_status.required' => 'Status tindak lanjut laporan wajib dipilih.',
        ]);

        DB::transaction(function () use ($report, $visit, $user, $validated) {
            $visit->update([
                'examination_notes' => $validated['examination_notes'],
                'post_visit_recommendations' => $validated['post_visit_recommendations'] ?? null,
                'status' => 'selesai',
                'completed_at' => now(),
            ]);

            $statusNotes = $validated['next_report_status'] === 'selesai'
                ? 'Pemeriksaan lapangan selesai dan penanganan laporan dinyatakan tuntas.'
                : 'Pemeriksaan lapangan selesai, menunggu tindak lanjut pengobatan peternak.';

            $report->transitionTo($validated['next_report_status'], $user->id, $statusNotes);
        });

        return redirect()->route('dokter-hewan.show', $report)
            ->with('success', 'Hasil pemeriksaan lapangan dan rekomendasi telah berhasil disimpan.');
    }

    /**
     * Explicitly update status of report with audit notes (e.g. marking as selesai).
     */
    public function updateStatus(Request $request, AnimalHealthReport $report): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'status' => ['required', 'in:sedang_ditangani,sudah_dijawab,menunggu_tindak_lanjut,selesai'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $report->transitionTo(
            $validated['status'],
            $user->id,
            $validated['notes'] ?? "Status diperbarui oleh {$user->name} menjadi {$report->getStatusLabelAttribute()}"
        );

        return redirect()->route('dokter-hewan.show', $report)
            ->with('success', "Status laporan berhasil diperbarui menjadi {$report->status_label}.");
    }

    /**
     * Field visits schedule directory for Veterinarian.
     */
    public function visits(Request $request): View
    {
        $query = AnimalHealthReportVisit::with(['report.user', 'veterinarian'])
            ->latest('proposed_date');

        $status = $request->query('status');
        if ($status) {
            $query->where('status', $status);
        }

        $visits = $query->paginate(12)->withQueryString();

        return view('dokter-hewan.visits', [
            'visits' => $visits,
            'currentStatus' => $status,
        ]);
    }
}
