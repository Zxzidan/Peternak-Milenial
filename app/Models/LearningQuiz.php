<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_material_id',
        'title',
        'description',
        'passing_score',
        'time_limit_minutes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'passing_score' => 'integer',
            'time_limit_minutes' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function learningMaterial(): BelongsTo
    {
        return $this->belongsTo(LearningMaterial::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function bestAttemptFor(?User $user): ?QuizAttempt
    {
        if (! $user) {
            return null;
        }

        return $this->attempts()
            ->where('user_id', $user->id)
            ->orderByDesc('score')
            ->first();
    }
}
