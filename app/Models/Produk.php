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
    protected $fillable = ['id_brand', 'id_sub_subkategori', 'nama_produk', 'slug', 'sku_produk', 'tipe_produk', 'asal_produk', 'dimensi_produk', 'deskripsi_produk', 'gambar_produk', 'harga_produk', 'stok_produk', 'status_produk', 'berat_produk'];

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
}
