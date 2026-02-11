<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\Brand;
use App\Models\Ulasan;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some references
        $brands = Brand::all();
        $subkategoris = Subkategori::all();
        $users = User::where('role_user', 'user')->get();

        if ($brands->count() == 0 || $subkategoris->count() == 0) {
            $this->command->info('Please run MasterDataSeeder first!');
            return;
        }

        // Create Dummy Products
        $products = [
            [
                'nama_produk' => 'Samsung Galaxy S24 Ultra',
                'deskripsi_produk' => 'The ultimate Galaxy smartphone with AI features.',
                'harga_produk' => 21999000,
                'stok_produk' => 50,
                'berat_produk' => 0.5,
                'gambar_produk' => 'samsung-galaxy-s24-ultra.jpg',
                'id_brand' => $brands->where('nama_brand', 'Samsung')->first()->id_brand ?? $brands->first()->id_brand,
                'id_subkategori' => $subkategoris->where('nama_kategori', 'Handphone')->first()->id_subkategori ?? $subkategoris->first()->id_subkategori,
            ],
            [
                'nama_produk' => 'MacBook Pro M3',
                'deskripsi_produk' => 'Mind-blowing performance with M3 chip.',
                'harga_produk' => 28999000,
                'stok_produk' => 25,
                'berat_produk' => 1.5,
                'gambar_produk' => 'macbook-pro-m3.jpg',
                'id_brand' => $brands->where('nama_brand', 'Apple')->first()->id_brand ?? $brands->first()->id_brand,
                'id_subkategori' => $subkategoris->where('nama_kategori', 'Laptop')->first()->id_subkategori ?? $subkategoris->first()->id_subkategori,
            ],
            [
                'nama_produk' => 'Nike Air Jordan 1',
                'deskripsi_produk' => 'Classic sneakers for everyday style.',
                'harga_produk' => 2500000,
                'stok_produk' => 100,
                'berat_produk' => 1.0,
                'gambar_produk' => 'nike-air-jordan-1.jpg',
                'id_brand' => $brands->where('nama_brand', 'Nike')->first()->id_brand ?? $brands->first()->id_brand,
                'id_subkategori' => $subkategoris->where('nama_kategori', 'Pria')->first()->id_subkategori ?? $subkategoris->first()->id_subkategori,
            ],
        ];

        foreach ($products as $data) {
            $produk = Produk::create($data);

            // Add some dummy reviews if users exist
            if ($users->count() > 0) {
                Ulasan::create([
                    'id_produk' => $produk->id_produk,
                    'id_user' => $users->random()->id_user,
                    'rating_ulasan' => rand(4, 5),
                    'komentar_ulasan' => 'Produk sangat bagus dan original!',
                    'tanggal_ulasan' => now(),
                ]);
            }
        }
    }
}
