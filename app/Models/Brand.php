<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand';
    protected $primaryKey = 'id_brand';
    protected $guarded = [];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_brand');
    }

    /**
     * Get the RGBA format of the overlay color and opacity.
     *
     * @return string
     */
    public function getRgbaOverlayAttribute()
    {
        $hex = $this->overlay_color ?: '#0EA5E9';
        $opacity = $this->overlay_opacity !== null ? $this->overlay_opacity : 70;
        $alpha = $opacity / 100;

        // Clean hex code
        $hex = str_replace('#', '', $hex);

        // Convert to RGB
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2) ?: '0');
            $g = hexdec(substr($hex, 2, 2) ?: '0');
            $b = hexdec(substr($hex, 4, 2) ?: '0');
        }

        return "rgba($r, $g, $b, $alpha)";
    }

    /**
     * Accessor for categories count that have products under this brand.
     */
    public function getCategoriesCountAttribute()
    {
        return Kategori::whereHas('subkategori.subSubkategori.produk', function($query) {
            $query->where('id_brand', $this->id_brand);
        })->count();
    }

    /**
     * Accessor for products count.
     */
    public function getProductsCountAttribute()
    {
        return $this->produk()->count();
    }
}
