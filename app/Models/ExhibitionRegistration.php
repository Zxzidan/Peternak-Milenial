<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibition_id',
        'user_id',
        'business_name',
        'exhibited_products',
        'status',
        'stand_number',
        'notes',
    ];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
