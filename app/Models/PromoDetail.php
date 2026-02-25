<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoDetail extends Model
{
    use HasFactory;

    protected $table = 'promo_details';
    protected $primaryKey = 'id_promo_detail';
    protected $guarded = [];

    protected $fillable = [
        'title',
        'description',
        'link',
        'active'
    ];

    public function promoBanners()
    {
        return $this->hasMany(PromoBanner::class, 'id_promo_detail');
    }
}
