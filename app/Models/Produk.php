<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['id_brand', 'id_sub_subkategori', 'nama_produk', 'sku_produk', 'tipe_produk', 'asal_produk', 'dimensi_produk', 'deskripsi_produk', 'gambar_produk', 'harga_produk', 'stok_produk', 'status_produk', 'berat_produk'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function subSubkategori()
    {
        return $this->belongsTo(SubSubkategori::class, 'id_sub_subkategori');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_produk');
    }

    public function wishlist() // Should be plural in usage but singular in ERD context usually refers to items
    {
        return $this->hasMany(Wishlist::class, 'id_produk');
    }
}
