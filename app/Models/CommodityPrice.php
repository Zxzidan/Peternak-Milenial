<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommodityPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'commodity_id',
        'region_id',
        'recorded_date',
        'farmer_price',
        'consumer_price',
        'price_change_7d',
        'price_change_percentage',
        'status',
        'source',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'recorded_date' => 'date',
            'farmer_price' => 'decimal:2',
            'consumer_price' => 'decimal:2',
            'price_change_7d' => 'decimal:2',
            'price_change_percentage' => 'decimal:2',
        ];
    }

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
