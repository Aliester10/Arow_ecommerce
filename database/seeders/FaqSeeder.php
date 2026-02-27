<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara melakukan pemesanan?',
                'jawaban' => '<p>Untuk melakukan pemesanan, ikuti langkah-langkah berikut:</p><ol><li>Pilih produk yang diinginkan</li><li>Klik tombol "Tambah ke Keranjang"</li><li>Periksa keranjang belanja Anda</li><li>Klik "Checkout" dan lengkapi data pengiriman</li><li>Pilih metode pembayaran</li><li>Selesaikan pembayaran</li></ol>',
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'pertanyaan' => 'Metode pembayaran apa saja yang tersedia?',
                'jawaban' => '<p>Kami menyediakan berbagai metode pembayaran:</p><ul><li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li><li>E-Wallet (OVO, GoPay, DANA, ShopeePay)</li><li>Kartu Kredit/Debit</li><li>QRIS</li><li>COD (Cash on Delivery) untuk area tertentu</li></ul>',
                'urutan' => 2,
                'is_active' => true
            ],
            [
                'pertanyaan' => 'Bagaimana proses pengiriman barang?',
                'jawaban' => '<p>Proses pengiriman barang:</p><ol><li>Pesanan diproses 1-2 hari kerja</li><li>Barang dikirim melalui ekspedisi terpercaya</li><li>Nomor resi akan dikirimkan via email/SMS</li><li>Estimasi pengiriman 2-7 hari tergantung lokasi</li><li>Status pengiriman dapat dilacak secara real-time</li></ol>',
                'urutan' => 3,
                'is_active' => true
            ],
            [
                'pertanyaan' => 'Apakah ada garansi untuk produk?',
                'jawaban' => '<p>Ya, kami menyediakan garansi untuk setiap produk:</p><ul><li>Garansi produk 1-3 tahun tergantung jenis produk</li><li>Garansi kepuasan 30 hari uang kembali</li><li>Garansi penggantian barang rusak saat pengiriman</li><li>Syarat dan ketentuan berlaku</li></ul>',
                'urutan' => 4,
                'is_active' => true
            ],
            [
                'pertanyaan' => 'Bagaimana cara melakukan pengembalian?',
                'jawaban' => '<p>Prosedur pengembalian barang:</p><ol><li>Hubungi CS kami dalam 7 hari setelah penerimaan</li><li>Sertakan foto/video kerusakan atau alasan pengembalian</li><li>Isi form pengembalian yang disediakan</li><li>Kirim barang kembali ke alamat yang ditentukan</li><li>Penggantian atau refund akan diproses 3-5 hari kerja</li></ol>',
                'urutan' => 5,
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
