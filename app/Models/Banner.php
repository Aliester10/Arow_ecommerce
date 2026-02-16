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
        'type', // main, promo_large, promo_small
        'position',
        'title',
        'subtitle',
        'link',
        'active'
    ];

    const TYPE_MAIN = 'main';
    const TYPE_PROMO_LARGE = 'promo_large';
    const TYPE_PROMO_SMALL = 'promo_small';
}
