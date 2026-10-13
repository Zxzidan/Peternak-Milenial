<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalHealthReportVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_health_report_id',
        'veterinarian_id',
        'created_by_id',
        'visit_reason',
        'proposed_date',
        'confirmed_date',
        'status',
        'farmer_notes',
        'examination_notes',
        'post_visit_recommendations',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'proposed_date' => 'datetime',
            'confirmed_date' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(AnimalHealthReport::class, 'animal_health_report_id');
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(Veterinarian::class, 'veterinarian_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'terjadwal' => 'Kunjungan Terjadwal',
            'sedang_berlangsung' => 'Sedang Berlangsung',
            'selesai' => 'Kunjungan Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'bg-amber-100 text-amber-800 border-amber-200',
            'terjadwal' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
            'sedang_berlangsung' => 'bg-blue-100 text-blue-800 border-blue-200',
            'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'dibatalkan' => 'bg-gray-100 text-gray-700 border-gray-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
