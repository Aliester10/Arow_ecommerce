<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubSubCategory extends Model
{
    protected $table = 'sub_subkategori';
    protected $primaryKey = 'id_sub_subkategori';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $routeKeyName = 'id_sub_subkategori';
    
    protected $fillable = [
        'id_subkategori',
        'nama_sub_subkategori'
    ];

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'id_subkategori', 'id_subkategori');
    }

    public function getCategoryAttribute()
    {
        return $this->subCategory?->category;
    }
}
