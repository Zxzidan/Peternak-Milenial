<?php

namespace App\Http\Controllers;

use App\Models\AnimalHealthReport;
use App\Models\AnimalHealthReportResponse;
use App\Models\AnimalHealthReportVisit;
use App\Models\Consultation;
use App\Models\Region;
use App\Services\HealthReportDistributionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalHealthReportController extends Controller
{
    /**
     * Display listing of health reports for the authenticated Peternak.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->isDokterHewan()) {
            return redirect()->route('dokter-hewan.dashboard');
        }

        $query = AnimalHealthReport::where('user_id', $user->id)
            ->with(['assignedVeterinarian', 'latestVisit'])
            ->latest();

        $tab = $request->query('tab', 'semua');
        if ($tab === 'menunggu_respons') {
            $query->whereIn('status', ['menunggu_respons', 'menunggu_penugasan']);
        } elseif ($tab === 'menunggu_penugasan') {
            $query->where('status', 'menunggu_penugasan');
        } elseif ($tab === 'sedang_ditangani') {
            $query->whereIn('status', ['sedang_ditangani', 'menunggu_kunjungan', 'kunjungan_terjadwal', 'menunggu_tindak_lanjut']);
        } elseif ($tab === 'sudah_dijawab') {
            $query->where('status', 'sudah_dijawab');
        } elseif ($tab === 'selesai') {
            $query->where('status', 'selesai');
        }

        $reports = $query->paginate(10)->withQueryString();

        // Real-time KPI summary for Peternak
        $stats = [
            'total' => AnimalHealthReport::where('user_id', $user->id)->count(),
            'menunggu_respons' => AnimalHealthReport::where('user_id', $user->id)->whereIn('status', ['menunggu_respons', 'menunggu_penugasan'])->count(),
            'sedang_ditangani' => AnimalHealthReport::where('user_id', $user->id)->whereIn('status', ['sedang_ditangani', 'menunggu_kunjungan', 'kunjungan_terjadwal', 'menunggu_tindak_lanjut'])->count(),
            'sudah_dijawab' => AnimalHealthReport::where('user_id', $user->id)->where('status', 'sudah_dijawab')->count(),
            'selesai' => AnimalHealthReport::where('user_id', $user->id)->where('status', 'selesai')->count(),
        ];

        return view('peternak.kesehatan.index', [
            'reports' => $reports,
            'stats' => $stats,
            'currentTab' => $tab,
        ]);
    }

    /**
     * Show form to submit a new animal health report.
     */
    public function create(): View
    {
        $user = auth()->user();
        $regions = Region::orderBy('name')->get();

        return view('peternak.kesehatan.create', [
            'user' => $user,
            'regions' => $regions,
        ]);
    }

    /**
     * Store newly created animal health report by Peternak.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'livestock_type' => ['required', 'string', 'max:100'],
            'affected_count' => ['required', 'integer', 'min:1'],
            'symptoms' => ['required', 'string'],
            'symptoms_started_at' => ['nullable', 'date', 'before_or_equal:today'],
            'urgency' => ['required', 'in:rendah,sedang,tinggi,kritis'],
            'farm_name' => ['nullable', 'string', 'max:255'],
            'farm_address' => ['nullable', 'string', 'max:500'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'livestock_type.required' => 'Jenis hewan ternak wajib diisi.',
            'affected_count.required' => 'Jumlah hewan ternak terdampak wajib diisi.',
            'symptoms.required' => 'Keluhan dan gejala klinis wajib dijelaskan.',
            'urgency.required' => 'Tingkat urgensi wajib dipilih.',
            'photo.max' => 'Ukuran foto pendukung maksimal 5 MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('animal_health_photos', 'public');
        }

        $report = DB::transaction(function () use ($user, $validated, $photoPath) {
            $reportNumber = AnimalHealthReport::generateReportNumber();

            $report = AnimalHealthReport::create([
                'report_number' => $reportNumber,
                'user_id' => $user->id,
                'livestock_type' => $validated['livestock_type'],
                'affected_count' => $validated['affected_count'],
                'symptoms' => $validated['symptoms'],
                'symptoms_started_at' => $validated['symptoms_started_at'] ?? null,
                'urgency' => $validated['urgency'],
                'farm_name' => $validated['farm_name'] ?? ($user->peternakProfile?->farm_name ?? 'Peternakan '.$user->name),
                'farm_address' => $validated['farm_address'] ?? ($user->alamat ?? null),
                'kabupaten' => $validated['kabupaten'] ?? ($user->kabupaten ?? 'Jawa Timur'),
                'photo_path' => $photoPath,
                'status' => 'menunggu_respons',
            ]);

            $report->statusHistories()->create([
                'changed_by_id' => $user->id,
                'previous_status' => null,
                'new_status' => 'menunggu_respons',
                'notes' => 'Laporan kesehatan hewan baru diajukan oleh peternak.',
            ]);

            // Distribusi otomatis berbasis beban kerja aktif dokter hewan terendah
            $distributionService = app(HealthReportDistributionService::class);
            $report = $distributionService->assignReport($report, $user->id);

            return $report;
        });

        $successMessage = $report->assignedVeterinarian
            ? "Laporan {$report->report_number} berhasil dikirim dan ditugaskan secara otomatis kepada {$report->assignedVeterinarian->name}."
            : "Laporan {$report->report_number} berhasil dikirim. Status saat ini: Menunggu Penugasan (akan otomatis dialokasikan saat dokter aktif).";

        return redirect()->route('kesehatan-hewan.show', $report)
            ->with('success', $successMessage);
    }

    /**
     * Show details of a health report, including doctor responses and visit status.
     * Enforces STRICT tenant isolation.
     */
    public function show(AnimalHealthReport $report): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->isDokterHewan()) {
            return redirect()->route('dokter-hewan.show', $report);
        }

        // Strict RBAC & Data Isolation
        if ($report->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses laporan kesehatan hewan peternak lain.');
        }

        $report->load([
            'user',
            'assignedVeterinarian',
            'consultation',
            'responses.user',
            'visits.veterinarian',
            'statusHistories.changer',
        ]);

        // Auto-heal / sync if consultation response exists but health report responses are empty
        if ($report->responses->isEmpty()) {
            $consultation = $report->consultation
                ?? Consultation::where('user_id', $report->user_id)
                    ->whereIn('status', ['selesai', 'answered', 'closed'])
                    ->latest()
                    ->first();

            if ($consultation && (! empty($consultation->doctor_notes) || ! empty($consultation->prescription) || ! empty($consultation->hypothesis))) {
                if (! $report->consultation_id) {
                    $report->updateQuietly(['consultation_id' => $consultation->id]);
                }
                if (! $consultation->animal_health_report_id) {
                    $consultation->updateQuietly(['animal_health_report_id' => $report->id]);
                }

                $doctorUserId = $consultation->veterinarian_id;

                AnimalHealthReportResponse::firstOrCreate(
                    [
                        'animal_health_report_id' => $report->id,
                        'user_id' => $doctorUserId,
                    ],
                    [
                        'message' => $consultation->doctor_notes ?: 'Pemeriksaan telemedisin dan konsultasi kesehatan ternak telah diselesaikan oleh dokter hewan dinas.',
                        'hypothesis' => $consultation->hypothesis ?: $report->symptoms,
                        'recommendations' => $consultation->recommendations ?: $consultation->prescription,
                        'follow_up_instructions' => $consultation->follow_up_instructions,
                        'urgency_level' => $consultation->urgency_level ?: 'sedang',
                        'requires_visit' => (bool) $consultation->requires_visit,
                        'notes' => $consultation->doctor_additional_notes,
                    ]
                );

                if ($consultation->requires_visit && $report->visits->isEmpty()) {
                    AnimalHealthReportVisit::firstOrCreate(
                        ['animal_health_report_id' => $report->id],
                        [
                            'veterinarian_id' => $report->assigned_veterinarian_id ?? 2,
                            'created_by_id' => $doctorUserId,
                            'visit_reason' => 'Kasus ini memerlukan Kunjungan Langsung ke Lokasi Peternakan oleh tim veteriner lapangan.',
                            'proposed_date' => now()->addDay()->setTime(9, 0),
                            'status' => 'menunggu_konfirmasi',
                        ]
                    );
                }

                $report->update([
                    'status' => 'selesai',
                    'resolved_at' => $report->resolved_at ?: now(),
                    'last_responded_at' => $report->last_responded_at ?: now(),
                ]);

                $report->load([
                    'consultation',
                    'responses.user',
                    'visits.veterinarian',
                ]);
            }
        }

        return view('peternak.kesehatan.show', [
            'report' => $report,
        ]);
    }

    /**
     * Allow peternak to reply with follow-up information or answers to doctor.
     */
    public function storeReply(Request $request, AnimalHealthReport $report): RedirectResponse
    {
        $user = auth()->user();

        if ($report->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang mengirim balasan pada laporan ini.');
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'message.required' => 'Pesan tanggapan peternak wajib diisi.',
        ]);

        AnimalHealthReportResponse::create([
            'animal_health_report_id' => $report->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Keep report active if currently waiting for follow up
        if ($report->status === 'menunggu_tindak_lanjut') {
            $report->transitionTo('sedang_ditangani', $user->id, 'Peternak memberikan informasi perkembangan kondisi hewan.');
        }

        return redirect()->route('kesehatan-hewan.show', $report)
            ->with('success', 'Balasan dan informasi tambahan berhasil dikirim ke Dokter Hewan.');
    }

    /**
     * Confirm a proposed field visit by the peternak.
     */
    public function confirmVisit(Request $request, AnimalHealthReport $report, AnimalHealthReportVisit $visit): RedirectResponse
    {
        $user = auth()->user();

        if ($report->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Akses Ditolak: Anda tidak berwenang mengonfirmasi kunjungan untuk peternak lain.');
        }

        $validated = $request->validate([
            'farmer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($report, $visit, $user, $validated) {
            $visit->update([
                'confirmed_date' => $visit->proposed_date,
                'status' => 'terjadwal',
                'farmer_notes' => $validated['farmer_notes'] ?? 'Dikonfirmasi siap dikunjungi oleh peternak.',
            ]);

            $report->transitionTo(
                'kunjungan_terjadwal',
                $user->id,
                'Peternak telah mengonfirmasi dan menyepakati jadwal kunjungan lapangan dokter.'
            );
        });

        return redirect()->route('kesehatan-hewan.show', $report)
            ->with('success', 'Jadwal kunjungan lapangan dokter hewan berhasil disetujui dan berstatus Terjadwal.');
    }
}
