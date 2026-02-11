<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkategori extends Model
{
    use HasFactory;

    protected $table = 'subkategori';
    protected $primaryKey = 'id_subkategori';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_subkategori');
    }
}
