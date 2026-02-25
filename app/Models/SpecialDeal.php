<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDeal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'subtitle',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->belongsToMany(Produk::class, 'special_deal_products', 'special_deal_id', 'id_produk')
                    ->withPivot('discount_percentage', 'is_active')
                    ->wherePivot('is_active', true)
                    ->where('status_produk', 'aktif');
    }

    public function activeProducts()
    {
        return $this->products()->where('is_active', true);
    }

    public function getRandomProducts($limit = 3)
    {
        return $this->activeProducts()->inRandomOrder()->limit($limit)->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
