<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function peternakProfiles(): HasMany
    {
        return $this->hasMany(PeternakProfile::class);
    }

    public function productionCenters(): HasMany
    {
        return $this->hasMany(ProductionCenter::class);
    }

    public function commodityPrices(): HasMany
    {
        return $this->hasMany(CommodityPrice::class);
    }

    public function emergencyReports(): HasMany
    {
        return $this->hasMany(EmergencyReport::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
