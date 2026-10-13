<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_quiz_id',
        'user_id',
        'score',
        'total_questions',
        'correct_answers_count',
        'user_answers',
        'passed',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'total_questions' => 'integer',
            'correct_answers_count' => 'integer',
            'user_answers' => 'array',
            'passed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(LearningQuiz::class, 'learning_quiz_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
