<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructor',
        'instructor_title',
        'start_date',
        'end_date',
        'time_info',
        'location',
        'is_online',
        'zoom_link',
        'zoom_meeting_id',
        'zoom_passcode',
        'quota',
        'remaining_quota',
        'cost_type',
        'status',
        'banner_image',
        'document_path',
        'document_name',
        'has_certificate',
        'certificate_title',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_online' => 'boolean',
            'has_certificate' => 'boolean',
            'quota' => 'integer',
            'remaining_quota' => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function isZoomOnline(): bool
    {
        return (bool) ($this->is_online || ! empty($this->zoom_link));
    }

    public function getZoomStatusAttribute(): string
    {
        $today = now()->startOfDay();
        $startDate = $this->start_date ? $this->start_date->startOfDay() : null;
        $endDate = $this->end_date ? $this->end_date->endOfDay() : null;

        if ($startDate && $today->lt($startDate)) {
            return 'upcoming';
        }

        if ($endDate && $today->gt($endDate)) {
            return 'completed';
        }

        return 'ongoing';
    }
}
