<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'veterinarian_id',
        'consultation_schedule_id',
        'booking_code',
        'livestock_id',
        'animal_health_report_id',
        'consultation_date',
        'consultation_time',
        'subject',
        'complaint_details',
        'doctor_notes',
        'hypothesis',
        'urgency_level',
        'prescription',
        'recommendations',
        'follow_up_instructions',
        'requires_visit',
        'doctor_additional_notes',
        'consultation_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consultation_date' => 'date',
            'requires_visit' => 'boolean',
        ];
    }

    public function peternak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ConsultationSchedule::class, 'consultation_schedule_id');
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }

    public function animalHealthReport(): BelongsTo
    {
        return $this->belongsTo(AnimalHealthReport::class, 'animal_health_report_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ConsultationMessage::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'dikonfirmasi' => 'Dikonfirmasi',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            'open' => 'Menunggu Respons',
            'answered' => 'Telah Dijawab',
            'closed' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi', 'open' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'dikonfirmasi', 'sedang_ditangani' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'selesai', 'answered', 'closed' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            'dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return match ($this->urgency_level) {
            'rendah' => 'Rendah (Observasi Rutin)',
            'sedang' => 'Sedang (Dalam 24–48 Jam)',
            'tinggi', 'darurat' => 'Tinggi / Darurat (Tindakan Segera)',
            default => $this->urgency_level ? ucfirst((string) $this->urgency_level) : 'Sedang',
        };
    }

    public function getUrgencyBadgeClassesAttribute(): string
    {
        return match ($this->urgency_level) {
            'rendah' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
            'sedang' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
            'tinggi', 'darurat' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800',
            default => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
        };
    }

    public function getTimeFormattedAttribute(): string
    {
        // Jika sesi konsultasi sudah selesai, tampilkan kapan selesainya sesi konsultasi (bukan range slot)
        if (in_array($this->status, ['selesai', 'answered', 'closed'])) {
            $completedAt = $this->updated_at ?? $this->created_at;

            return $completedAt
                ? 'Selesai pukul '.$completedAt->timezone('Asia/Jakarta')->format('H:i').' WIB'
                : 'Selesai';
        }

        if ($this->schedule?->time_slot_label) {
            return $this->schedule->time_slot_label;
        }

        if ($this->schedule?->time_label) {
            return $this->schedule->time_label;
        }

        if (! empty($this->consultation_time)) {
            $time = trim((string) $this->consultation_time);

            return str_ends_with(strtoupper($time), 'WIB') ? $time : "{$time} WIB";
        }

        if ($this->created_at) {
            return $this->created_at->timezone('Asia/Jakarta')->format('H:i').' WIB';
        }

        return 'Waktu Belum Diatur';
    }
}
