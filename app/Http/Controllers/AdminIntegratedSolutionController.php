<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntegratedSolution;
use App\Models\IntegratedSolutionCategory;
use App\Models\Kategori;

class AdminIntegratedSolutionController extends Controller
{
    public function index()
    {
        $integratedSolution = IntegratedSolution::first();
        $categories = Kategori::all();
        $selectedCategories = [];
        
        if ($integratedSolution) {
            $selectedCategories = $integratedSolution->categories()->with('kategori')->get();
        }
        
        return view('admin.integrated-solutions.index', compact('integratedSolution', 'categories', 'selectedCategories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'button_color' => 'required|string|max:7',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'array|max:3',
            'categories.*' => 'exists:kategori,id_kategori',
            'category_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $integratedSolution = IntegratedSolution::firstOrCreate([]);
        
        $integratedSolution->title = $request->title;
        $integratedSolution->button_text = $request->button_text;
        $integratedSolution->button_color = $request->button_color;
        $integratedSolution->is_active = $request->has('is_active');
        
        if ($request->hasFile('background_image')) {
            $imageName = time() . '_bg.' . $request->background_image->extension();
            $request->background_image->move(public_path('storage/images/integrated-solutions'), $imageName);
            $integratedSolution->background_image = 'integrated-solutions/' . $imageName;
        }
        
        $integratedSolution->save();

        // Update categories
        if ($request->has('categories')) {
            // Remove existing categories
            $integratedSolution->categories()->delete();
            
            // Add new categories
            foreach ($request->categories as $index => $categoryId) {
                $categoryImage = null;
                if ($request->hasFile("category_images.$index")) {
                    $imageName = time() . '_cat_' . $index . '.' . $request->file("category_images.$index")->extension();
                    $request->file("category_images.$index")->move(public_path('storage/images/integrated-solutions'), $imageName);
                    $categoryImage = 'integrated-solutions/' . $imageName;
                }
                
                IntegratedSolutionCategory::create([
                    'integrated_solution_id' => $integratedSolution->id,
                    'kategori_id' => $categoryId,
                    'category_image' => $categoryImage,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.integrated-solutions.index')
            ->with('success', 'Integrated Solutions updated successfully.');
    }
}
