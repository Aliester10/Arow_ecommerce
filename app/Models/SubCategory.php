<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    protected $table = 'subkategori';
    protected $primaryKey = 'id_subkategori';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $routeKeyName = 'id_subkategori';
    
    protected $fillable = [
        'id_kategori',
        'nama_subkategori'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    public function subSubCategories(): HasMany
    {
        return $this->hasMany(SubSubCategory::class, 'id_subkategori', 'id_subkategori');
    }
}
