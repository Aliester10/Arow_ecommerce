<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PromoBanner;

class PromoDetail extends Model
{
    protected $table = 'promo_details';
    protected $primaryKey = 'id_promo_detail';
    protected $guarded = [];

    protected $fillable = [
        'id_promo_banner',
        'judul_detail',
        'deskripsi',
        'gambar_tambahan',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function promoBanner()
    {
        return $this->belongsTo(PromoBanner::class, 'id_promo_banner', 'id_promo_banner');
    }
}
