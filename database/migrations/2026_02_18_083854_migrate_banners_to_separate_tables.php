<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear tables first
        \DB::table('slider_banners')->truncate();
        \DB::table('promo_banners')->truncate();

        // Migrate slider banners
        $sliderBanners = \DB::table('banner')->where('type', 'slider')->get();
        foreach ($sliderBanners as $banner) {
            \DB::table('slider_banners')->insert([
                'id_slider_banner' => $banner->id_banner,
                'gambar_slider_banner' => $banner->gambar_banner,
                'position' => $banner->position ?? 0,
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'active' => $banner->active ?? true,
                'created_at' => $banner->created_at ?? now(),
                'updated_at' => $banner->updated_at ?? now(),
            ]);
        }

        // Migrate promo banners
        $promoBanners = \DB::table('banner')->whereIn('type', ['promo_large', 'promo_small'])->get();
        foreach ($promoBanners as $banner) {
            \DB::table('promo_banners')->insert([
                'id_promo_banner' => $banner->id_banner,
                'gambar_promo_banner' => $banner->gambar_banner,
                'position' => $banner->position ?? 0,
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'link' => $banner->link ?? '',
                'active' => $banner->active ?? true,
                'created_at' => $banner->created_at ?? now(),
                'updated_at' => $banner->updated_at ?? now(),
            ]);
        }

        // Create sample promo banners if none exist
        if ($promoBanners->isEmpty()) {
            \DB::table('promo_banners')->insert([
                [
                    'id_promo_banner' => 100,
                    'gambar_promo_banner' => 'banner/sample_promo_1.jpg',
                    'position' => 1,
                    'title' => 'Promo Banner 1',
                    'subtitle' => 'Sample promo banner for testing',
                    'link' => 'https://example.com/promo-1',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_promo_banner' => 101,
                    'gambar_promo_banner' => 'banner/sample_promo_2.jpg',
                    'position' => 2,
                    'title' => 'Promo Banner 2',
                    'subtitle' => 'Sample promo banner 2',
                    'link' => 'https://example.com/promo-2',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_promo_banner' => 102,
                    'gambar_promo_banner' => 'banner/sample_promo_3.jpg',
                    'position' => 3,
                    'title' => 'Promo Banner 3',
                    'subtitle' => 'Sample promo banner 3',
                    'link' => 'https://example.com/promo-3',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_promo_banner' => 103,
                    'gambar_promo_banner' => 'banner/sample_promo_4.jpg',
                    'position' => 4,
                    'title' => 'Promo Banner 4',
                    'subtitle' => 'Sample promo banner 4',
                    'link' => 'https://example.com/promo-4',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_promo_banner' => 104,
                    'gambar_promo_banner' => 'banner/sample_promo_5.jpg',
                    'position' => 5,
                    'title' => 'Promo Banner 5',
                    'subtitle' => 'Sample promo banner 5',
                    'link' => 'https://example.com/promo-5',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the new tables
        \DB::table('slider_banners')->truncate();
        \DB::table('promo_banners')->truncate();
    }
};
