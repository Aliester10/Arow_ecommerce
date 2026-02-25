<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * This migration seeds essential data that exists locally but may be missing on production.
 * It uses insertOrIgnore / updateOrInsert to avoid duplicates.
 */
return new class extends Migration {
    public function up(): void
    {
        // ============================================================
        // 1. SPECIAL DEALS
        // ============================================================
        if (Schema::hasTable('special_deals')) {
            $existingDeal = DB::table('special_deals')->first();
            if (!$existingDeal) {
                DB::table('special_deals')->insert([
                    'id' => 1,
                    'title' => 'Special Deals',
                    'subtitle' => 'for this year',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ============================================================
        // 2. IN-HOUSE BRAND (2nd brand: aro baskara esa education)
        // ============================================================
        if (Schema::hasTable('brand')) {
            $brand14 = DB::table('brand')->where('id_brand', 14)->first();
            if (!$brand14) {
                DB::table('brand')->insert([
                    'id_brand' => 14,
                    'nama_brand' => 'aro baskara esa education',
                    'deskripsi_brand' => '',
                    'logo_brand' => '1771989830_logo.png',
                    'gambar_background' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ============================================================
        // 3. FOOTER LINKS
        // ============================================================
        if (Schema::hasTable('footer_links')) {
            $existingLinks = DB::table('footer_links')->count();
            if ($existingLinks === 0) {
                DB::table('footer_links')->insert([
                    // LAYANAN PELANGGAN
                    [
                        'column_title' => 'LAYANAN PELANGGAN',
                        'type' => 'text',
                        'label' => 'Bantuan',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'LAYANAN PELANGGAN',
                        'type' => 'text',
                        'label' => 'Metode Pembayaran',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'LAYANAN PELANGGAN',
                        'type' => 'text',
                        'label' => 'Lacak Pesanan',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'LAYANAN PELANGGAN',
                        'type' => 'text',
                        'label' => 'Kebijakan Privasi',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 4,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    // INFORMASI
                    [
                        'column_title' => 'INFORMASI',
                        'type' => 'text',
                        'label' => 'Tentang Kami',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'INFORMASI',
                        'type' => 'text',
                        'label' => 'Karir',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'INFORMASI',
                        'type' => 'text',
                        'label' => 'Blog',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'INFORMASI',
                        'type' => 'text',
                        'label' => 'Mitra',
                        'url' => '#',
                        'image_path' => null,
                        'order' => 4,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }

        // ============================================================
        // 4. PERUSAHAAN DATA (update if exists, insert if not)
        // ============================================================
        if (Schema::hasTable('perusahaan')) {
            $existing = DB::table('perusahaan')->first();
            if (!$existing) {
                DB::table('perusahaan')->insert([
                    'nama_perusahaan' => 'PT. ARO BASKARA ESA',
                    'visi' => 'Menjadi perusahaan ecommerce terpercaya di Indonesia',
                    'misi' => 'Menyediakan produk berkualitas dan layanan terbaik',
                    'footer_description' => '',
                    'alamat_perusahaan' => 'Jl. TM. Slamet Riyadi Raya No. 9 RT.1 RW.4 Kb. Manggis. Kec. Matraman, Daerah Khusus Ibukota Jakarta 13150',
                    'notelp_perusahaan' => '(021) 38835187 / +62 822-8888-6009',
                    'email_perusahaan' => 'sales@ayobelanja.co.id',
                    'website_perusahaan' => 'ayobelanja.co.id',
                    'facebook' => 'https://www.facebook.com/',
                    'logo_perusahaan' => '1771218097_logo.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ============================================================
        // 5. ADMIN USER (ensure at least one admin exists)
        // ============================================================
        if (Schema::hasTable('users')) {
            $adminExists = DB::table('users')->where('role_user', 'admin')->exists();
            if (!$adminExists) {
                DB::table('users')->insert([
                    'nama_user' => 'Administrator',
                    'email_user' => 'admin@admin.com',
                    'password_user' => Hash::make('password'),
                    'role_user' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ============================================================
        // 6. INTEGRATED SOLUTIONS (seed default data if empty)
        // ============================================================
        if (Schema::hasTable('integrated_solutions')) {
            $existing = DB::table('integrated_solutions')->first();
            if (!$existing) {
                DB::table('integrated_solutions')->insert([
                    'id' => 1,
                    'title' => 'Integrated Solutions for Modern Businesses',
                    'background_image' => null,
                    'button_text' => 'See Now',
                    'button_color' => '#FF5F57',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // This is a data seeder — no structural changes to reverse
    }
};
