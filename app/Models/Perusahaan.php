<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $fillable = [
        'nama_perusahaan',
        'visi',
        'misi',
        'alamat_perusahaan',
        'notelp_perusahaan',
        'phone_alt',
        'email_perusahaan',
        'email_sales',
        'website_perusahaan',
        'logo_perusahaan',
        'footer_description',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'tiktok',
        'youtube',
        'member_of_image',
    ];
}
