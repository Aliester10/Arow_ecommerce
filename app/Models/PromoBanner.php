<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    protected $table = 'promo_banners';
    protected $primaryKey = 'id_promo_banner';
    protected $guarded = [];

    protected $fillable = [
        'gambar_promo_banner',
        'id_promo_detail',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function promoDetails()
    {
        return $this->hasMany(PromoDetail::class, 'id_promo_banner', 'id_promo_banner');
    }

    public function activePromoDetail()
    {
        return $this->belongsTo(PromoDetail::class, 'id_promo_detail', 'id_promo_detail');
    }
}
