<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAppearanceController extends Controller
{
    public function header()
    {
        $perusahaan = \App\Models\Perusahaan::find(1);
        return view('admin.appearance.header', compact('perusahaan'));
    }

    public function updateHeader(Request $request)
    {
        $perusahaan = \App\Models\Perusahaan::find(1);

        $data = $request->validate([
            'nama_perusahaan' => 'nullable|string',
            'notelp_perusahaan' => 'nullable|string',
            'email_perusahaan' => 'nullable|email',
            'logo_perusahaan' => 'nullable|image',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            if ($perusahaan->logo_perusahaan && \Storage::disk('public')->exists('images/' . $perusahaan->logo_perusahaan)) {
                \Storage::disk('public')->delete('images/' . $perusahaan->logo_perusahaan);
            }
            $image = $request->file('logo_perusahaan');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['logo_perusahaan'] = $imageName;
        }

        $perusahaan->update($data);

        // Redirect back with a fragment to keep the user on the same tab if using tabs, or just back
        return redirect()->back()->with('success', 'Header updated successfully');
    }

    public function footer()
    {
        $perusahaan = \App\Models\Perusahaan::find(1);
        $footerLinks = \App\Models\FooterLink::all()->groupBy('column_title');
        $shippingLinks = \App\Models\FooterLink::where('column_title', 'PENGIRIMAN')->orderBy('order')->get();
        return view('admin.appearance.footer', compact('perusahaan', 'footerLinks', 'shippingLinks'));
    }

    public function updateFooter(Request $request)
    {
        $perusahaan = \App\Models\Perusahaan::find(1);

        $data = $request->validate([
            'alamat_perusahaan' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'notelp_perusahaan' => 'nullable|string',
            'email_perusahaan' => 'nullable|email',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'youtube' => 'nullable|url',
            'member_of_image' => 'nullable|image',
        ]);

        if ($request->hasFile('member_of_image')) {
            if ($perusahaan->member_of_image && \Storage::disk('public')->exists('images/' . $perusahaan->member_of_image)) {
                \Storage::disk('public')->delete('images/' . $perusahaan->member_of_image);
            }
            $image = $request->file('member_of_image');
            $imageName = time() . '_memberof.' . $image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['member_of_image'] = $imageName;
        }

        // Handle Shipping Links Updates
        if ($request->has('shipping_links')) {
            foreach ($request->shipping_links as $id => $linkData) {
                $link = \App\Models\FooterLink::find($id);
                if ($link) {
                    $link->url = $linkData['url'];

                    if ($request->hasFile("shipping_links.{$id}.image")) {
                        // Delete old image
                        if ($link->image_path && \Storage::exists('public/footer_images/' . $link->image_path)) {
                            \Storage::delete('public/footer_images/' . $link->image_path);
                        }

                        $file = $request->file("shipping_links.{$id}.image");
                        $filename = time() . '_' . $link->label . '_' . $file->getClientOriginalName();
                        $file->storeAs('footer_images', $filename, 'public');
                        $link->image_path = $filename;
                        $link->type = 'image'; // Ensure type is set to image
                    }

                    $link->save();
                }
            }
        }

        $perusahaan->update($data);

        return redirect()->back()->with('success', 'Footer updated successfully');
    }

    public function integratedSolutions()
    {
        $integratedSolution = \App\Models\IntegratedSolution::first();
        $categories = \App\Models\Kategori::all();
        $integratedCategories = $integratedSolution ? $integratedSolution->activeCategories : collect();
        
        // Convert to indexed array for easier access in view
        $indexedCategories = [];
        foreach ($integratedCategories as $index => $category) {
            $indexedCategories[$index] = $category;
        }
        
        // Debug: Log the data
        \Log::info('Integrated Solutions Data', [
            'solution' => $integratedSolution,
            'categories_count' => $categories->count(),
            'integrated_categories_count' => $integratedCategories->count(),
            'indexed_categories' => $indexedCategories
        ]);
        
        return view('admin.appearance.integrated-solutions', compact('integratedSolution', 'categories', 'integratedCategories'))->with('indexedCategories', $indexedCategories);
    }

    public function updateIntegratedSolutions(Request $request)
    {
        $integratedSolution = \App\Models\IntegratedSolution::firstOrCreate([]);

        // Validate background image
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array|min:1|max:3',
            'categories.*' => 'exists:kategori,id_kategori',
            'category_images' => 'nullable|array',
            'category_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            if ($integratedSolution->background_image && \Storage::disk('public')->exists('images/' . $integratedSolution->background_image)) {
                \Storage::disk('public')->delete('images/' . $integratedSolution->background_image);
            }
            $image = $request->file('background_image');
            $imageName = time() . '_integrated_bg.' . $image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('images', $image, $imageName);
            $integratedSolution->background_image = $imageName;
        }

        $integratedSolution->save();

        // Clear existing categories
        \App\Models\IntegratedSolutionCategory::where('integrated_solution_id', $integratedSolution->id)->delete();

        // Add new categories with images
        if ($request->has('categories')) {
            foreach ($request->categories as $index => $categoryId) {
                // Skip empty category selections
                if (empty($categoryId)) continue;
                
                $categoryData = [
                    'integrated_solution_id' => $integratedSolution->id,
                    'kategori_id' => $categoryId,
                    'is_active' => true,
                    'sort_order' => $index,
                ];

                // Handle category image upload
                if ($request->hasFile("category_images.{$index}")) {
                    $image = $request->file("category_images.{$index}");
                    $categoryImageName = time() . "_cat_{$index}." . $image->getClientOriginalExtension();
                    \Storage::disk('public')->putFileAs('images', $image, $categoryImageName);
                    $categoryData['category_image'] = $categoryImageName;
                }

                \App\Models\IntegratedSolutionCategory::create($categoryData);
            }
        }

        return redirect()->back()->with('success', 'Integrated Solutions updated successfully');
    }
}
