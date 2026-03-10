<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImportTemplate implements FromArray, WithHeadings, WithTitle, WithColumnWidths, WithStyles
{
    protected $brands;
    protected $categories;

    public function __construct()
    {
        $this->brands = \App\Models\Brand::pluck('nama_brand', 'nama_brand')->toArray();
        $this->categories = \App\Models\Kategori::pluck('nama_kategori', 'nama_kategori')->toArray();
    }

    public function array(): array
    {
        $examples = [
            [
                'Laptop ASUS ROG Gaming',
                'ASUS',
                'Electronics',
                'Laptops',
                'Gaming Laptops',
                'ASUS-ROG-001',
                'Gaming',
                'Taiwan',
                '35.5 x 23.5 x 2.3 cm',
                '15000000',
                '10',
                '2.5',
                'High-performance gaming laptop with RTX graphics, 16GB RAM, 512GB SSD',
                'laptop_asus_rog.jpg'
            ],
            [
                'iPhone 15 Pro Max 256GB',
                'Apple',
                'Electronics',
                'Smartphones',
                'Premium Phones',
                'IPHONE-15-PRO-256',
                'Premium',
                'USA',
                '14.6 x 7.1 x 0.8 cm',
                '20000000',
                '15',
                '0.2',
                'Latest iPhone with titanium design, A17 Pro chip, 256GB storage',
                'iphone_15_pro_max.png'
            ],
            [
                'Meja Kerja Kayu Jati',
                'Jati Furniture',
                'Furniture',
                'Office Furniture',
                'Desks',
                'MEJA-JATI-001',
                'Modern',
                'Indonesia',
                '120 x 60 x 75 cm',
                '2500000',
                '5',
                '15.5',
                'Meja kerja dari kayu jati berkualitas tinggi, finishing natural, anti rayap',
                'meja_kerja_kayu_jati.jpg'
            ]
        ];

        $instructions = [
            ['CONTOH DATA PRODUK - HAPUS BARIS INI SEBELUM IMPORT'],
            [''],
            [''],
            ['PETUNJUK PENGISIAN:'],
            ['1. Nama Produk: Wajib diisi, maksimal 255 karakter'],
            ['2. Brand: Wajib diisi, harus ada di database'],
            ['3. Kategori: Wajib diisi, harus ada di database'],
            ['4. Sub Kategori: Opsional, harus ada di database jika diisi'],
            ['5. Sub-Sub Kategori: Opsional, harus ada di database jika diisi'],
            ['6. SKU: Opsional, kode unik produk'],
            ['7. Tipe/Cover: Opsional, tipe atau cover produk'],
            ['8. Asal Negara: Opsional, negara asal produk'],
            ['9. Dimensi: Opsional, format: P x L x T'],
            ['10. Harga: Opsional, angka tanpa format (contoh: 15000000)'],
            ['11. Stok: Wajib diisi, angka (contoh: 10)'],
            ['12. Berat: Wajib diisi, angka dalam kg (contoh: 2.5)'],
            ['13. Spesifikasi Produk: Wajib diisi, deskripsi lengkap'],
            ['14. Gambar Produk: Opsional, nama file gambar (contoh: produk.jpg)'],
            [''],
            ['🖼️ PENTING - PENGELOLAAN GAMBAR:'],
            ['1. Upload semua gambar terlebih dahulu di halaman Import > Tab "Upload Gambar"'],
            ['2. Gunakan drag & drop atau klik untuk upload multiple file'],
            ['3. Format gambar: JPG, PNG, GIF, WebP (maksimal 2MB per file)'],
            ['4. Kolom "Gambar Produk" diisi dengan nama file yang sudah diupload'],
            ['5. Pastikan nama file di Excel sama persis dengan nama file yang diupload'],
            ['6. Contoh: jika upload "meja_kayu.jpg", maka di Excel tulis "meja_kayu.jpg"'],
            ['7. Jika gambar tidak ditemukan, produk tidak akan diimport'],
            [''],
            ['BRAND YANG TERSEDIA:'],
            array_merge(['Brand:'], array_keys($this->brands)),
            [''],
            ['KATEGORI YANG TERSEDIA:'],
            array_merge(['Kategori:'], array_keys($this->categories)),
            [''],
            ['DATA CONTOH:'],
        ];

        return array_merge($instructions, $examples);
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Brand',
            'Kategori',
            'Sub Kategori',
            'Sub-Sub Kategori',
            'SKU',
            'Tipe/Cover',
            'Asal Negara',
            'Dimensi',
            'Harga',
            'Stok',
            'Berat',
            'Spesifikasi Produk',
            'Gambar Produk'
        ];
    }

    public function title(): string
    {
        return 'Template Import Produk';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 20,
            'F' => 15,
            'G' => 12,
            'H' => 12,
            'I' => 20,
            'J' => 12,
            'K' => 8,
            'L' => 8,
            'M' => 40,
            'N' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ]
            ],
            'A1:N1' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
