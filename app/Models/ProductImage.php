<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    protected $fillable = ['id_produk', 'image_path', 'sort_order', 'is_primary'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    /**
     * Get the full URL for the image
     */
    public function getUrlAttribute()
    {
        return '/storage/' . $this->image_path;
    }
}
