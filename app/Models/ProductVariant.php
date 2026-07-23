<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    protected $primaryKey = 'id_variant';
    
    protected $fillable = [
        'id_produk',
        'variant_combination',
        'harga_produk',
        'stok_produk',
        'sku_produk',
        'gambar_produk',
    ];

    protected $casts = [
        'variant_combination' => 'array',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    
    public function getVariantNameAttribute()
    {
        if (is_array($this->variant_combination)) {
            $parts = [];
            foreach ($this->variant_combination as $key => $value) {
                $parts[] = $value;
            }
            return implode(', ', $parts);
        }
        return '';
    }
}
