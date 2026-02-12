<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubkategori extends Model
{
    use HasFactory;

    protected $table = 'sub_subkategori';
    protected $primaryKey = 'id_sub_subkategori';
    protected $guarded = [];

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_sub_subkategori');
    }
}
