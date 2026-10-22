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
        'consultation_date',
        'consultation_time',
        'subject',
        'complaint_details',
        'doctor_notes',
        'prescription',
        'consultation_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consultation_date' => 'date',
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
