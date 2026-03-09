<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'position' => 'Sales Eksekutif',
                'description' => "1. Mencari dan mendapatkan pelanggan baru\n2. Memelihara hubungan baik dengan pelanggan yang ada\n3. Mencapai target penjualan yang ditetapkan\n4. Memberikan presentasi produk kepada calon pelanggan\n5. Membuat laporan penjualan harian dan mingguan",
                'qualifications' => "1. Pendidikan minimal SMA/SMK sederajat\n2. Pengalaman minimal 1 tahun di bidang sales\n3. Memiliki kemampuan komunikasi yang baik\n4. Target oriented dan memiliki motivasi tinggi\n5. Dapat mengendarai motor dan memiliki SIM C",
                'location' => 'Jakarta Timur',
                'employment_type' => 'Full Time',
                'email' => 'hr@perusahaan.com',
                'is_active' => true,
            ],
            [
                'position' => 'Digital Marketing Specialist',
                'description' => "1. Mengelola media sosial perusahaan\n2. Membuat konten digital yang menarik\n3. Melakukan analisis pasar dan kompetitor\n4. Mengoptimalkan SEO dan SEM\n5. Membuat laporan performa marketing",
                'qualifications' => "1. Pendidikan minimal D3/S1 Marketing/Communication\n2. Pengalaman minimal 2 tahun di digital marketing\n3. Mahir menggunakan social media tools\n4. Memahami SEO dan Google Analytics\n5. Kreatif dan inovatif",
                'location' => 'Jakarta Selatan',
                'employment_type' => 'Full Time',
                'email' => 'marketing@perusahaan.com',
                'is_active' => true,
            ],
            [
                'position' => 'Customer Service',
                'description' => "1. Menangani keluhan dan pertanyaan pelanggan\n2. Memberikan informasi produk yang akurat\n3. Membantu proses pemesanan pelanggan\n4. Membuat laporan layanan pelanggan\n5. Berkoordinasi dengan tim terkait",
                'qualifications' => "1. Pendidikan minimal SMA/SMK sederajat\n2. Pengalaman minimal 1 tahun di customer service\n3. Memiliki kemampuan komunikasi yang baik\n4. Sabar dan ramah dalam melayani pelanggan\n5. Dapat mengoperasikan komputer dengan baik",
                'location' => 'Jakarta Pusat',
                'employment_type' => 'Full Time',
                'email' => 'cs@perusahaan.com',
                'is_active' => true,
            ],
            [
                'position' => 'Content Creator',
                'description' => "1. Membuat konten untuk media sosial\n2. Menulis artikel dan blog\n3. Menghasilkan video konten\n4. Mengedit foto dan video\n5. Berkolaborasi dengan tim marketing",
                'qualifications' => "1. Pendidikan minimal D3/S1 Komunikasi/Jurnalistik\n2. Pengalaman minimal 1 tahun sebagai content creator\n3. Mahir menggunakan editing software\n4. Memiliki portofolio konten kreatif\n5. Up to date dengan trend digital",
                'location' => 'Tangerang',
                'employment_type' => 'Part Time',
                'email' => 'creative@perusahaan.com',
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
}
