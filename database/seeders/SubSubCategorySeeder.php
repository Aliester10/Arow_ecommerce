<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Models\SubSubkategori;

class SubSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and subcategories
        $elektronik = Kategori::where('nama_kategori', 'Elektronik')->first();
        $fashion = Kategori::where('nama_kategori', 'Fashion')->first();
        
        if ($elektronik) {
            $handphone = Subkategori::where('nama_subkategori', 'Handphone')->first();
            $laptop = Subkategori::where('nama_subkategori', 'Laptop')->first();
            $aksesoris = Subkategori::where('nama_subkategori', 'Aksesoris Utk Gadget')->first();
            
            if ($handphone) {
                SubSubkategori::create(['id_subkategori' => $handphone->id_subkategori, 'nama_sub_subkategori' => 'Smartphone']);
                SubSubkategori::create(['id_subkategori' => $handphone->id_subkategori, 'nama_sub_subkategori' => 'Tablet']);
            }
            
            if ($laptop) {
                SubSubkategori::create(['id_subkategori' => $laptop->id_subkategori, 'nama_sub_subkategori' => 'Laptop Gaming']);
                SubSubkategori::create(['id_subkategori' => $laptop->id_subkategori, 'nama_sub_subkategori' => 'Ultrabook']);
            }
            
            if ($aksesoris) {
                SubSubkategori::create(['id_subkategori' => $aksesoris->id_subkategori, 'nama_sub_subkategori' => 'Headphone']);
                SubSubkategori::create(['id_subkategori' => $aksesoris->id_subkategori, 'nama_sub_subkategori' => 'Charger']);
            }
        }
        
        if ($fashion) {
            $pria = Subkategori::where('nama_subkategori', 'Pria')->first();
            $wanita = Subkategori::where('nama_subkategori', 'Wanita')->first();
            
            if ($pria) {
                SubSubkategori::create(['id_subkategori' => $pria->id_subkategori, 'nama_sub_subkategori' => 'Sepatu Pria']);
                SubSubkategori::create(['id_subkategori' => $pria->id_subkategori, 'nama_sub_subkategori' => 'Baju Pria']);
            }
            
            if ($wanita) {
                SubSubkategori::create(['id_subkategori' => $wanita->id_subkategori, 'nama_sub_subkategori' => 'Sepatu Wanita']);
                SubSubkategori::create(['id_subkategori' => $wanita->id_subkategori, 'nama_sub_subkategori' => 'Baju Wanita']);
            }
        }
    }
}
