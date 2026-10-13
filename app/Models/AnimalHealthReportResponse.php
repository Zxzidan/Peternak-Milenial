<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalHealthReportResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_health_report_id',
        'user_id',
        'message',
        'hypothesis',
        'recommendations',
        'follow_up_instructions',
        'urgency_level',
        'requires_visit',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'requires_visit' => 'boolean',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(AnimalHealthReport::class, 'animal_health_report_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isFromDoctor(): bool
    {
        return $this->user?->isDokterHewan() || $this->user?->isAdmin();
    }
}
