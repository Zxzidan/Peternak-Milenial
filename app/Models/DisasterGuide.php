<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'disaster_type',
        'summary',
        'content',
        'sop_document_path',
        'partner_agency',
    ];
}
