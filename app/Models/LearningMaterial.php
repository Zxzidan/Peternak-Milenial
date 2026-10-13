<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'topic',
        'file_path',
        'file_size',
        'video_url',
        'thumbnail',
        'duration',
        'author_institution',
        'instructor_name',
        'level',
        'downloads_count',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'downloads_count' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(LearningQuiz::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(LearningQuiz::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserLearningProgress::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (! empty($this->thumbnail)) {
            if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
                return $this->thumbnail;
            }

            return asset('storage/'.$this->thumbnail);
        }

        // Default cover based on category / topic
        return asset('img/bestseller/1.png');
    }

    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $url = $this->video_url;

        // If already embed URL
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        // Match youtu.be/<id>
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        // Match youtube.com/watch?v=<id>
        if (preg_match('/[?&]v=([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $url;
    }

    public function progressFor(?User $user): ?UserLearningProgress
    {
        if (! $user) {
            return null;
        }

        return $this->progress->firstWhere('user_id', $user->id);
    }
}
