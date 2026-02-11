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

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
