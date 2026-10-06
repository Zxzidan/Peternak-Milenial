<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_type',
        'event_date',
        'time_info',
        'location',
        'region_id',
        'is_mandatory',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_mandatory' => 'boolean',
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
