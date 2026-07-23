<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_item';
    protected $primaryKey = 'id_order_item';
    protected $guarded = [];

    protected $casts = [
        'variant_details' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_product_variant', 'id_variant');
    }
}
