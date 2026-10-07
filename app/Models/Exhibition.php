<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'facilities',
        'start_date',
        'end_date',
        'location',
        'stand_capacity',
        'registered_stands_count',
        'is_featured',
        'banner_image',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'stand_capacity' => 'integer',
            'registered_stands_count' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(ExhibitionRegistration::class);
    }
}
