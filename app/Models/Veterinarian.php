<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Veterinarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'specialization',
        'puskeswan',
        'strv_number',
        'phone_number',
        'email',
        'status',
        'consultation_hours',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getInitialsAttribute(): string
    {
        // Extract initials from name, omitting "drh." prefix if present
        $cleanName = preg_replace('/^drh\.?\s*/i', '', $this->name);
        $words = explode(' ', trim($cleanName));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }

        return $initials ?: 'DR';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'online' => 'Online (Siaga)',
            'praktik_lapangan' => 'Praktik Lapangan',
            'siaga' => 'Siaga Panggilan',
            'offline' => 'Sedang Istirahat',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
