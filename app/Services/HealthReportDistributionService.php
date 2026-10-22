<?php

namespace App\Services;

use App\Models\AnimalHealthReport;
use App\Models\Veterinarian;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class HealthReportDistributionService
{
    /**
     * Report statuses that count towards a veterinarian's active workload.
     * As specified: Menunggu Respons and Sedang Ditangani count as active.
     * Terjawab (sudah_dijawab) and Selesai are no longer active.
     */
    public const ACTIVE_WORKLOAD_STATUSES = [
        'menunggu_respons',
        'sedang_ditangani',
    ];

    /**
     * Retrieve all veterinarians eligible to receive reports.
     * Must be active, not offline, and have an active user account.
     *
     * @return Collection<int, Veterinarian>
     */
    public function getAvailableVeterinarians(): Collection
    {
        return Veterinarian::query()
            ->where('is_active', true)
            ->where('status', '!=', 'offline')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->get();
    }

    /**
     * Select the eligible veterinarian with the lowest active workload.
     * Tie-breaking mechanism:
     * 1. Lowest active workload (reports in menunggu_respons or sedang_ditangani)
     * 2. Doctors who have never received an assignment, or received one the furthest in the past (least recently assigned)
     * 3. Lowest veterinarian ID (deterministic fallback)
     */
    public function selectDoctorWithLowestWorkload(): ?Veterinarian
    {
        $availableVets = $this->getAvailableVeterinarians();

        if ($availableVets->isEmpty()) {
            return null;
        }

        $vetIds = $availableVets->pluck('id');

        return Veterinarian::query()
            ->whereIn('id', $vetIds)
            ->withCount([
                'assignedHealthReports as active_reports_count' => function ($query) {
                    $query->whereIn('status', self::ACTIVE_WORKLOAD_STATUSES);
                },
            ])
            ->withMax('assignedHealthReports as last_assigned_at', 'created_at')
            ->orderBy('active_reports_count', 'asc')
            ->orderByRaw('last_assigned_at IS NULL DESC')
            ->orderBy('last_assigned_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Automatically assign an animal health report to the doctor with lowest workload.
     * If no doctor is currently available, marks the report as 'menunggu_penugasan'.
     * Uses DB lock to prevent race conditions during concurrent submissions.
     */
    public function assignReport(AnimalHealthReport $report, ?int $triggeredById = null): AnimalHealthReport
    {
        return DB::transaction(function () use ($report, $triggeredById) {
            /** @var AnimalHealthReport $lockedReport */
            $lockedReport = AnimalHealthReport::lockForUpdate()->find($report->id);

            if (! $lockedReport) {
                return $report;
            }

            $doctor = $this->selectDoctorWithLowestWorkload();

            if ($doctor) {
                $previousStatus = $lockedReport->status;
                $lockedReport->assigned_veterinarian_id = $doctor->id;
                $lockedReport->status = 'menunggu_respons';
                $lockedReport->save();

                $lockedReport->statusHistories()->create([
                    'changed_by_id' => $triggeredById,
                    'previous_status' => $previousStatus,
                    'new_status' => 'menunggu_respons',
                    'notes' => "Laporan didistribusikan secara otomatis kepada {$doctor->name} (beban kerja terendah).",
                ]);
            } else {
                $previousStatus = $lockedReport->status;
                $lockedReport->assigned_veterinarian_id = null;
                $lockedReport->status = 'menunggu_penugasan';
                $lockedReport->save();

                $lockedReport->statusHistories()->create([
                    'changed_by_id' => $triggeredById,
                    'previous_status' => $previousStatus,
                    'new_status' => 'menunggu_penugasan',
                    'notes' => 'Tidak ada dokter hewan yang sedang aktif/tersedia. Laporan disimpan dalam antrean Menunggu Penugasan.',
                ]);
            }

            return $lockedReport;
        });
    }

    /**
     * Distribute pending reports (status 'menunggu_penugasan' or null assigned_veterinarian_id)
     * when doctors become available or when workloads are freed up.
     *
     * @return int Number of reports successfully assigned
     */
    public function distributePendingReports(): int
    {
        $pendingReports = AnimalHealthReport::query()
            ->where(function ($query) {
                $query->where('status', 'menunggu_penugasan')
                    ->orWhereNull('assigned_veterinarian_id');
            })
            ->whereNotIn('status', ['selesai'])
            ->orderBy('created_at', 'asc')
            ->lockForUpdate()
            ->get();

        $assignedCount = 0;

        foreach ($pendingReports as $report) {
            $doctor = $this->selectDoctorWithLowestWorkload();

            if (! $doctor) {
                // No available doctors left, break early
                break;
            }

            $previousStatus = $report->status;
            $report->assigned_veterinarian_id = $doctor->id;
            $report->status = 'menunggu_respons';
            $report->save();

            $report->statusHistories()->create([
                'changed_by_id' => null,
                'previous_status' => $previousStatus,
                'new_status' => 'menunggu_respons',
                'notes' => "Laporan dalam antrean otomatis ditugaskan kepada {$doctor->name}.",
            ]);

            $assignedCount++;
        }

        return $assignedCount;
    }

    /**
     * Get the active workload count for a specific veterinarian.
     */
    public function getActiveWorkload(Veterinarian $veterinarian): int
    {
        return $veterinarian->assignedHealthReports()
            ->whereIn('status', self::ACTIVE_WORKLOAD_STATUSES)
            ->count();
    }
}
