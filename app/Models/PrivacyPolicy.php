<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $fillable = [
        'title',
        'subtitle', 
        'introduction',
        'last_updated',
        'sections',
        'is_active'
    ];

    protected $casts = [
        'sections' => 'array',
        'last_updated' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Get the active privacy policy
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}
