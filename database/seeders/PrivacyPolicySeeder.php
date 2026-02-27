<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrivacyPolicy;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivacyPolicy::create([
            'title' => 'Kebijakan Privasi',
            'subtitle' => 'PT Aro Baskara Esa',
            'introduction' => 'Di PT Aro Baskara Esa, kami berkomitmen untuk melindungi data pribadi pengguna dan memastikan keamanan informasi yang Anda percayakan kepada kami. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda sesuai dengan peraturan perundang-undangan yang berlaku.',
            'last_updated' => now()->parse('2026-02-25'),
            'sections' => [
                [
                    'title' => 'Informasi yang Kami Kumpulkan',
                    'items' => [
                        'Nama lengkap',
                        'Alamat email',
                        'Nomor telepon',
                        'Alamat pengiriman',
                        'Data transaksi',
                        'Informasi perangkat dan IP Address',
                        'Riwayat aktivitas pengguna di website'
                    ]
                ],
                [
                    'title' => 'Penggunaan Informasi',
                    'items' => [
                        'Memproses pesanan dan pembayaran',
                        'Mengatur pengiriman produk',
                        'Memberikan layanan pelanggan',
                        'Mengelola akun pengguna',
                        'Mengirimkan informasi promosi (jika disetujui pengguna)',
                        'Meningkatkan kualitas layanan'
                    ]
                ],
                [
                    'title' => 'Perlindungan dan Keamanan Data',
                    'items' => [
                        'Sistem enkripsi',
                        'Pembatasan akses internal',
                        'Pengamanan server',
                        'Pemantauan sistem secara berkala'
                    ]
                ],
                [
                    'title' => 'Pembagian Informasi kepada Pihak Ketiga',
                    'items' => [
                        'Bank dan penyedia pembayaran',
                        'Perusahaan jasa pengiriman',
                        'Mitra teknologi informasi',
                        'Penyedia layanan pendukung'
                    ],
                    'description' => 'Pembagian data dilakukan hanya untuk keperluan operasional layanan.'
                ],
                [
                    'title' => 'Hak Pengguna',
                    'items' => [
                        'Mengakses data pribadi',
                        'Memperbarui informasi akun',
                        'Meminta penghapusan akun',
                        'Menolak komunikasi promosi',
                        'Mengajukan keberatan atas penggunaan data'
                    ],
                    'description' => 'Permintaan dapat disampaikan melalui kontak resmi Kami.'
                ],
                [
                    'title' => 'Penggunaan Cookies',
                    'items' => [
                        'Menyimpan preferensi pengguna',
                        'Meningkatkan pengalaman penggunaan',
                        'Menganalisis aktivitas pengunjung'
                    ],
                    'description' => 'Pengguna dapat mengatur penggunaan cookies melalui browser masing-masing.'
                ]
            ],
            'is_active' => true
        ]);
    }
}
