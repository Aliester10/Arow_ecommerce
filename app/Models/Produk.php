<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['id_kategori', 'id_subkategori', 'id_brand', 'id_sub_subkategori', 'nama_produk', 'slug', 'sku_produk', 'tipe_produk', 'asal_produk', 'dimensi_produk', 'deskripsi_produk', 'gambar_produk', 'harga_produk', 'stok_produk', 'status_produk', 'berat_produk'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori');
    }

    /**
     * Auto-generate slug from nama_produk on create/update.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->nama_produk);
        });

        static::updating(function ($product) {
            if ($product->isDirty('nama_produk')) {
                $product->slug = static::generateUniqueSlug($product->nama_produk, $product->id_produk);
            }
        });
    }

    /**
     * Generate a unique slug, appending a counter if needed.
     */
    public static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id_produk', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id_produk', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function subSubkategori()
    {
        return $this->belongsTo(SubSubkategori::class, 'id_sub_subkategori');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_produk');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id_produk');
    }

    public function specialDeals()
    {
        return $this->belongsToMany(SpecialDeal::class, 'special_deal_products', 'id_produk', 'special_deal_id')
            ->withPivot('discount_percentage', 'is_active')
            ->wherePivot('is_active', true);
    }

    public function getSpecialDealPriceAttribute()
    {
        $specialDeal = $this->specialDeals()->first();
        if ($specialDeal) {
            $discountPercentage = $specialDeal->pivot->discount_percentage;
            return $this->harga_produk * (1 - $discountPercentage / 100);
        }
        return null;
    }

    public function getSpecialDealDiscountAttribute()
    {
        $specialDeal = $this->specialDeals()->first();
        return $specialDeal ? $specialDeal->pivot->discount_percentage : null;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_produk')->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'id_produk')->where('is_primary', true);
    }

    public function getFirstImageAttribute()
    {
        $primaryImage = $this->primaryImage;
        if ($primaryImage) {
            return $primaryImage;
        }
        
        return $this->images()->first();
    }

    public function getImageUrlAttribute()
    {
        if ($this->firstImage) {
            return $this->firstImage->url;
        }
        
        // Fallback to legacy single image if exists
        if ($this->gambar_produk) {
            return asset('storage/products/' . $this->gambar_produk);
        }
        
        return asset('images/default-product.jpg');
    }
}
