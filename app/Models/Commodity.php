<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'unit',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(CommodityPrice::class);
    }

    public function productionCenters(): HasMany
    {
        return $this->hasMany(ProductionCenter::class);
    }
}
