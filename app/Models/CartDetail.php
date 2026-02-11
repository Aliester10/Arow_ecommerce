<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'cart_detail';
    protected $primaryKey = 'id_cart_detail';
    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
