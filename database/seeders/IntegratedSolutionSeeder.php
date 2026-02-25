<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IntegratedSolution;
use App\Models\IntegratedSolutionCategory;
use App\Models\Kategori;

class IntegratedSolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $integratedSolution = IntegratedSolution::create([
            'title' => 'Integrated Solutions for Modern Businesses',
            'background_image' => 'integrated-solutions-bg.jpg',
            'button_text' => 'See Now',
            'button_color' => '#FF5F57',
            'is_active' => true,
        ]);

        // Get first 3 categories as default
        $categories = Kategori::take(3)->get();
        
        foreach ($categories as $index => $category) {
            IntegratedSolutionCategory::create([
                'integrated_solution_id' => $integratedSolution->id,
                'kategori_id' => $category->id_kategori,
                'category_image' => 'category-' . ($index + 1) . '.jpg',
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
