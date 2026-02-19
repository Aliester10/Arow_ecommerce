<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
    protected $primaryKey = 'id_banner';
    protected $guarded = [];

    protected $fillable = [
        'gambar_banner',
        'type', // slider, promo_large, promo_small
        'position',
        'title',
        'subtitle',
        'link',
        'active'
    ];

    const TYPE_SLIDER = 'slider'; // Main Banner (Slider Utama) - display only
    const TYPE_PROMO_LARGE = 'promo_large'; // Promo Large (Kiri) - clickable
    const TYPE_PROMO_SMALL = 'promo_small'; // Promo Small (Kanan) - clickable
}
