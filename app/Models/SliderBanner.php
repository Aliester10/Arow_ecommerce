<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderBanner extends Model
{
    protected $table = 'slider_banners';
    protected $primaryKey = 'id_slider_banner';
    protected $guarded = [];

    protected $fillable = [
        'gambar_slider_banner',
        'position',
        'title',
        'subtitle',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'position' => 'integer',
    ];
}
