<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'career_postings';
    
    protected $fillable = [
        'position',
        'description',
        'qualifications',
        'location',
        'employment_type',
        'email',
        'is_active'
    ];
}
