<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecialDeal;
use App\Models\Produk;

class SpecialDealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample special deal
        $specialDeal = SpecialDeal::create([
            'title' => 'Special Deals',
            'subtitle' => 'For This Year',
            'is_active' => true,
        ]);

        // Get some sample products
        $products = Produk::where('status_produk', 'active')->take(5)->get();
        
        if ($products->count() >= 3) {
            // Attach products with different discount percentages
            $discounts = [20, 40, 50];
            
            foreach ($products->take(3) as $index => $product) {
                $specialDeal->products()->attach($product->id_produk, [
                    'discount_percentage' => $discounts[$index],
                    'is_active' => true,
                ]);
            }
        }
    }
}
