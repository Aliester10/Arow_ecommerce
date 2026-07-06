<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PromoCampaign;
use App\Models\Produk;

class PromoCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample promo campaign
        $promoCampaign = PromoCampaign::create([
            'title' => 'Promo Launching ABE',
            'slug' => 'promo-launching-abe',
            'subtitle' => 'Diskon Spesial Hingga 50% untuk Produk Pilihan',
            'description' => 'Rayakan launching website baru kami dengan diskon menarik untuk berbagai produk pilihan Anda. Promo ini berlaku terbatas.',
            'banner' => null, // banner will be uploaded manually or remains null as fallback
            'start_date' => now()->subDays(1),
            'end_date' => now()->addDays(30),
            'status' => 'aktif',
        ]);

        // Get some active products to attach to this promo campaign
        $products = Produk::where('status_produk', 'aktif')->take(5)->get();

        if ($products->count() > 0) {
            $discountTypes = ['percent', 'percent', 'nominal', 'percent', 'nominal'];
            $discountValues = [20, 40, 100000, 15, 25000];

            foreach ($products as $index => $product) {
                $promoCampaign->products()->attach($product->id_produk, [
                    'discount_type' => $discountTypes[$index] ?? 'percent',
                    'discount_value' => $discountValues[$index] ?? 10,
                ]);
            }
        }
    }
}
