<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $guarded = [];

    public function subkategori()
    {
        return $this->hasMany(Subkategori::class, 'id_kategori', 'id_kategori');
    }
}
