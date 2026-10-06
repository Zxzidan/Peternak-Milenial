<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'symptoms',
        'prevention_steps',
        'treatment_first_aid',
    ];
}
