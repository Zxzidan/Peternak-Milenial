<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalHealthReportStatusHistory extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'animal_health_report_id',
        'changed_by_id',
        'previous_status',
        'new_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(AnimalHealthReport::class, 'animal_health_report_id');
    }

    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_id');
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'menunggu_respons' => 'Menunggu Respons',
            'sedang_ditangani' => 'Sedang Ditangani',
            'sudah_dijawab' => 'Sudah Dijawab',
            'menunggu_kunjungan' => 'Menunggu Kunjungan',
            'kunjungan_terjadwal' => 'Kunjungan Terjadwal',
            'menunggu_tindak_lanjut' => 'Menunggu Tindak Lanjut',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }
}
