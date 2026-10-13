<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLearningProgress extends Model
{
    use HasFactory;

    protected $table = 'user_learning_progress';

    protected $fillable = [
        'user_id',
        'learning_material_id',
        'is_watched',
        'watch_percentage',
        'last_watched_at',
    ];

    protected function casts(): array
    {
        return [
            'is_watched' => 'boolean',
            'watch_percentage' => 'integer',
            'last_watched_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(LearningMaterial::class, 'learning_material_id');
    }
}
