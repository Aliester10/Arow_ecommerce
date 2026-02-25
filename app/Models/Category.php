<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $routeKeyName = 'id_kategori';
    
    protected $fillable = [
        'nama_kategori',
        'icon_kategori'
    ];

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'id_kategori', 'id_kategori');
    }
}
