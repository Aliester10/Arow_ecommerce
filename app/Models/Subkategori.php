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

    public function subSubkategori()
    {
        return $this->hasMany(SubSubkategori::class, 'id_subkategori');
    }

    public function produk()
    {
        return $this->hasManyThrough(
            Produk::class,
            SubSubkategori::class,
            'id_subkategori',
            'id_sub_subkategori',
            'id_subkategori',
            'id_sub_subkategori'
        );
    }
}
