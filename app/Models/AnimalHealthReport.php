<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class AnimalHealthReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'user_id',
        'assigned_veterinarian_id',
        'livestock_type',
        'affected_count',
        'symptoms',
        'symptoms_started_at',
        'medical_history',
        'urgency',
        'farm_name',
        'farm_address',
        'kabupaten',
        'additional_notes',
        'photo_path',
        'status',
        'last_responded_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'affected_count' => 'integer',
            'symptoms_started_at' => 'date',
            'last_responded_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public static function generateReportNumber(): string
    {
        $prefix = 'LKH-'.now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;

        return sprintf('%s-%04d-%s', $prefix, $count, $random);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedVeterinarian(): BelongsTo
    {
        return $this->belongsTo(Veterinarian::class, 'assigned_veterinarian_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AnimalHealthReportResponse::class, 'animal_health_report_id')->oldest();
    }

    public function visits(): HasMany
    {
        return $this->hasMany(AnimalHealthReportVisit::class, 'animal_health_report_id')->latest();
    }

    public function latestVisit(): HasOne
    {
        return $this->hasOne(AnimalHealthReportVisit::class, 'animal_health_report_id')->latestOfMany();
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(AnimalHealthReportStatusHistory::class, 'animal_health_report_id')->latest('created_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_respons' => 'Menunggu Respons',
            'sedang_ditangani' => 'Sedang Ditangani',
            'sudah_dijawab' => 'Sudah Dijawab',
            'menunggu_kunjungan' => 'Menunggu Kunjungan',
            'kunjungan_terjadwal' => 'Kunjungan Terjadwal',
            'menunggu_tindak_lanjut' => 'Menunggu Tindak Lanjut',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'menunggu_respons' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'sedang_ditangani' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'sudah_dijawab' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-950/60 dark:text-indigo-300 dark:border-indigo-800',
            'menunggu_kunjungan' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-950/60 dark:text-orange-300 dark:border-orange-800',
            'kunjungan_terjadwal' => 'bg-cyan-100 text-cyan-800 border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-300 dark:border-cyan-800',
            'menunggu_tindak_lanjut' => 'bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match ($this->urgency) {
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'kritis' => 'Kritis (Darurat)',
            default => ucfirst((string) $this->urgency),
        };
    }

    public function getUrgencyBadgeClassesAttribute(): string
    {
        return match ($this->urgency) {
            'rendah' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
            'sedang' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
            'tinggi' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:border-orange-800',
            'kritis' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function transitionTo(string $newStatus, ?int $changedById = null, ?string $notes = null): void
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;

        if ($newStatus === 'selesai' && ! $this->resolved_at) {
            $this->resolved_at = now();
        }

        $this->save();

        $this->statusHistories()->create([
            'changed_by_id' => $changedById,
            'previous_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
        ]);
    }
}
