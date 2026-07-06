<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCampaignProduct extends Model
{
    use HasFactory;

    protected $table = 'promo_campaign_products';

    protected $fillable = [
        'promo_campaign_id',
        'product_id',
        'discount_type',
        'discount_value'
    ];

    public function promoCampaign()
    {
        return $this->belongsTo(PromoCampaign::class, 'promo_campaign_id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'id_produk');
    }
}
