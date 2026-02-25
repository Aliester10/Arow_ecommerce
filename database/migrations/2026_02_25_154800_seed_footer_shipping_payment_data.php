<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

/**
 * Seed footer PENGIRIMAN (shipping), PEMBAYARAN (payment) entries,
 * copy footer images from public/seed_images to storage,
 * and add social media links for IKUTI KAMI section.
 */
return new class extends Migration {
    public function up(): void
    {
        // ============================================================
        // 1. Copy seed images to storage footer_images directory
        // ============================================================
        $seedDir = public_path('seed_images/footer');
        $targetDir = storage_path('app/public/footer_images');

        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        // Copy images with proper names
        $imageMap = [
            '1771220104_TIKI_tiki.png' => '1771220104_TIKI_tiki.png',
            '1771220081_JNE_download.png' => '1771220081_JNE_download.png',
            'qris.png' => 'qris_payment.png',
            'tambah.png' => 'tambah_shipping.png',
        ];

        foreach ($imageMap as $source => $dest) {
            $sourcePath = $seedDir . '/' . $source;
            $destPath = $targetDir . '/' . $dest;
            if (File::exists($sourcePath) && !File::exists($destPath)) {
                File::copy($sourcePath, $destPath);
            }
        }

        // Ensure storage link exists
        $publicLink = public_path('storage');
        if (!File::exists($publicLink)) {
            try {
                \Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Storage link might already exist or not be possible
            }
        }

        // ============================================================
        // 2. Seed PENGIRIMAN footer links
        // ============================================================
        if (Schema::hasTable('footer_links')) {
            $hasPengiriman = DB::table('footer_links')
                ->where('column_title', 'PENGIRIMAN')
                ->exists();

            if (!$hasPengiriman) {
                DB::table('footer_links')->insert([
                    [
                        'column_title' => 'PENGIRIMAN',
                        'type' => 'image',
                        'label' => 'TIKI',
                        'url' => '#',
                        'image_path' => '1771220104_TIKI_tiki.png',
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'PENGIRIMAN',
                        'type' => 'image',
                        'label' => 'JNE',
                        'url' => '#',
                        'image_path' => '1771220081_JNE_download.png',
                        'order' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'column_title' => 'PENGIRIMAN',
                        'type' => 'image',
                        'label' => 'Pengiriman Lainnya',
                        'url' => '#',
                        'image_path' => 'tambah_shipping.png',
                        'order' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }

            // ============================================================
            // 3. Seed PEMBAYARAN footer links
            // ============================================================
            $hasPembayaran = DB::table('footer_links')
                ->where('column_title', 'PEMBAYARAN')
                ->exists();

            if (!$hasPembayaran) {
                DB::table('footer_links')->insert([
                    [
                        'column_title' => 'PEMBAYARAN',
                        'type' => 'image',
                        'label' => 'QRIS',
                        'url' => '#',
                        'image_path' => 'qris_payment.png',
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }

        // ============================================================
        // 4. Update perusahaan social media for IKUTI KAMI section
        // ============================================================
        if (Schema::hasTable('perusahaan')) {
            $perusahaan = DB::table('perusahaan')->first();
            if ($perusahaan) {
                $updates = [];
                if (empty($perusahaan->facebook)) {
                    $updates['facebook'] = 'https://www.facebook.com/';
                }
                if (empty($perusahaan->instagram)) {
                    $updates['instagram'] = 'https://www.instagram.com/';
                }
                if (!empty($updates)) {
                    $updates['updated_at'] = now();
                    DB::table('perusahaan')
                        ->where('id_perusahaan', $perusahaan->id_perusahaan)
                        ->update($updates);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('footer_links')) {
            DB::table('footer_links')->where('column_title', 'PENGIRIMAN')->delete();
            DB::table('footer_links')->where('column_title', 'PEMBAYARAN')->delete();
        }
    }
};
