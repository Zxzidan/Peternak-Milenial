<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'commodity_id',
        'name',
        'description',
        'livestock_population',
        'latitude',
        'longitude',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'livestock_population' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }
}
