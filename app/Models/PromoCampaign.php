<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCampaign extends Model
{
    use HasFactory;

    protected $table = 'promo_campaigns';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'banner',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function products()
    {
        return $this->belongsToMany(Produk::class, 'promo_campaign_products', 'promo_campaign_id', 'product_id')
            ->withPivot('id', 'discount_type', 'discount_value')
            ->withTimestamps();
    }
}
