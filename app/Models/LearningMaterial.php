<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'file_path',
        'file_size',
        'duration',
        'author_institution',
        'downloads_count',
    ];

    protected function casts(): array
    {
        return [
            'downloads_count' => 'integer',
        ];
    }
}
