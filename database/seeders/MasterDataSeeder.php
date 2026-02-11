<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\Brand;
use App\Models\Perusahaan;
use App\Models\Banner;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perusahaan
        Perusahaan::create([
            'nama_perusahaan' => 'Arow Ecommerce',
            'visi' => 'Menjadi platform ecommerce terdepan.',
            'misi' => 'Memberikan pengalaman belanja terbaik.',
            'alamat_perusahaan' => 'Jl. Teknologi No. 123, Jakarta',
            'notelp_perusahaan' => '081234567890',
            'email_perusahaan' => 'info@arow.com',
            'website_perusahaan' => 'www.arow.com',
            'logo_perusahaan' => 'logo.png',
        ]);

        // Banners
        Banner::create(['gambar_banner' => 'banner1.jpg']);
        Banner::create(['gambar_banner' => 'banner2.jpg']);
        Banner::create(['gambar_banner' => 'banner3.jpg']);

        // Brand
        $samsung = Brand::create([
            'nama_brand' => 'Samsung',
            'deskripsi_brand' => 'Global electronics leader.',
            'logo_brand' => 'samsung.png'
        ]);
        
        $apple = Brand::create([
            'nama_brand' => 'Apple',
            'deskripsi_brand' => 'Think Different.',
            'logo_brand' => 'apple.png'
        ]);

        $nike = Brand::create([
            'nama_brand' => 'Nike',
            'deskripsi_brand' => 'Just Do It.',
            'logo_brand' => 'nike.png'
        ]);

        // Kategori & Subkategori
        $elektronik = Kategori::create(['nama_kategori' => 'Elektronik']);
        Subkategori::create(['id_kategori' => $elektronik->id_kategori, 'nama_kategori' => 'Handphone']);
        Subkategori::create(['id_kategori' => $elektronik->id_kategori, 'nama_kategori' => 'Laptop']);
        Subkategori::create(['id_kategori' => $elektronik->id_kategori, 'nama_kategori' => 'Aksesoris Utk Gadget']);

        $fashion = Kategori::create(['nama_kategori' => 'Fashion']);
        Subkategori::create(['id_kategori' => $fashion->id_kategori, 'nama_kategori' => 'Pria']);
        Subkategori::create(['id_kategori' => $fashion->id_kategori, 'nama_kategori' => 'Wanita']);
        Subkategori::create(['id_kategori' => $fashion->id_kategori, 'nama_kategori' => 'Anak-anak']);
    }
}
