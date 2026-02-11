<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['id_brand', 'id_subkategori', 'nama_produk', 'deskripsi_produk', 'harga_produk', 'stok_produk', 'status_produk', 'berat_produk', 'gambar_produk'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori');
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
