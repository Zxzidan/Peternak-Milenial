<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsultationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'veterinarian_id',
        'date',
        'start_time',
        'end_time',
        'quota',
        'status',
        'service_type',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'quota' => 'integer',
        ];
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(Veterinarian::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function activeConsultations(): HasMany
    {
        return $this->hasMany(Consultation::class)->where('status', '!=', 'dibatalkan');
    }

    public function getBookedCountAttribute(): int
    {
        if ($this->relationLoaded('consultations')) {
            return $this->consultations->where('status', '!=', 'dibatalkan')->count();
        }

        return $this->activeConsultations()->count();
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota - $this->booked_count);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->remaining_quota <= 0;
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'buka' && ! $this->is_full;
    }

    public function getTimeSlotLabelAttribute(): string
    {
        $start = substr((string) $this->start_time, 0, 5);
        $end = substr((string) $this->end_time, 0, 5);

        return "{$start} - {$end} WIB";
    }

    public function getTimeLabelAttribute(): string
    {
        return $this->time_slot_label;
    }
}
