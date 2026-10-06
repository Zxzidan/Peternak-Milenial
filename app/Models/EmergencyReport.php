<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmergencyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_code',
        'user_id',
        'region_id',
        'incident_type',
        'livestock_type',
        'affected_count',
        'location_address',
        'latitude',
        'longitude',
        'description',
        'photo_path',
        'status',
        'officer_notes',
        'assigned_officer_id',
        'officer_phone',
        'verified_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'affected_count' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'verified_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_officer_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(EmergencyReportLog::class);
    }
}
