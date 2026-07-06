<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_brand' => 'required|string|max:255',
            'deskripsi_brand' => 'nullable|string',
            'logo_brand' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gambar_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_title' => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:100',
            'banner_button_link' => 'nullable|string|max:255',
            'overlay_color' => 'nullable|string|max:20',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo_brand')) {
            $image = $request->file('logo_brand');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['logo_brand'] = $imageName;
        }

        if ($request->hasFile('gambar_background')) {
            $image = $request->file('gambar_background');
            $imageName = time() . '_bg.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_background'] = $imageName;
        }

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['banner_image'] = $imageName;
        }

        // Toggles for brand statistics
        $data['show_product_count'] = $request->has('show_product_count') ? 1 : 0;
        $data['show_category_count'] = $request->has('show_category_count') ? 1 : 0;
        $data['show_official_badge'] = $request->has('show_official_badge') ? 1 : 0;

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'nama_brand' => 'required|string|max:255',
            'deskripsi_brand' => 'nullable|string',
            'logo_brand' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gambar_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_title' => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:100',
            'banner_button_link' => 'nullable|string|max:255',
            'overlay_color' => 'nullable|string|max:20',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
        ]);

        $data = $request->except(['logo_brand', 'gambar_background', 'banner_image']);

        if ($request->hasFile('logo_brand')) {
            if ($brand->logo_brand) {
                Storage::disk('public')->delete('images/' . $brand->logo_brand);
            }
            $image = $request->file('logo_brand');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['logo_brand'] = $imageName;
        }

        if ($request->hasFile('gambar_background')) {
            if ($brand->gambar_background) {
                Storage::disk('public')->delete('images/' . $brand->gambar_background);
            }
            $image = $request->file('gambar_background');
            $imageName = time() . '_bg.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_background'] = $imageName;
        }

        if ($request->hasFile('banner_image')) {
            if ($brand->banner_image) {
                Storage::disk('public')->delete('images/' . $brand->banner_image);
            }
            $image = $request->file('banner_image');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['banner_image'] = $imageName;
        }

        // Toggles for brand statistics
        $data['show_product_count'] = $request->has('show_product_count') ? 1 : 0;
        $data['show_category_count'] = $request->has('show_category_count') ? 1 : 0;
        $data['show_official_badge'] = $request->has('show_official_badge') ? 1 : 0;

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->logo_brand) {
            Storage::disk('public')->delete('images/' . $brand->logo_brand);
        }
        if ($brand->gambar_background) {
            Storage::disk('public')->delete('images/' . $brand->gambar_background);
        }
        if ($brand->banner_image) {
            Storage::disk('public')->delete('images/' . $brand->banner_image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil dihapus!');
    }

    public function settings()
    {
        $brands = Brand::all();
        // Separating in-house brands for cleaner categorization in settings UI
        $inHouseBrandNames = ['ABE living', 'ABE edu', 'aro baskara esa living', 'aro  baskara esa living', 'aro baskara esa education', 'aro  baskara esa education'];
        
        $inHouseBrands = $brands->filter(function($brand) use ($inHouseBrandNames) {
            return in_array(strtolower($brand->nama_brand), array_map('strtolower', $inHouseBrandNames));
        });
        
        $otherBrands = $brands->reject(function($brand) use ($inHouseBrandNames) {
            return in_array(strtolower($brand->nama_brand), array_map('strtolower', $inHouseBrandNames));
        });

        return view('admin.brands.settings', compact('brands', 'inHouseBrands', 'otherBrands'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'id_brand' => 'required|exists:brand,id_brand',
            'overlay_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'overlay_opacity' => 'required|integer|min:0|max:100',
        ], [
            'overlay_color.regex' => 'Format warna HEX tidak valid (harus diawali # dan berisi 3 atau 6 karakter hex).',
            'overlay_opacity.min' => 'Opacity minimal 0%.',
            'overlay_opacity.max' => 'Opacity maksimal 100%.',
        ]);

        $brand = Brand::findOrFail($request->id_brand);
        $brand->update([
            'overlay_color' => $request->overlay_color,
            'overlay_opacity' => $request->overlay_opacity,
        ]);

        return redirect()->route('admin.brands.settings')->with('success', 'Pengaturan warna brand ' . $brand->nama_brand . ' berhasil diperbarui!');
    }

    public function updateSettingsAjax(Request $request)
    {
        try {
            $request->validate([
                'id_brand' => 'required|exists:brand,id_brand',
                'overlay_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
                'overlay_opacity' => 'required|integer|min:0|max:100',
            ]);

            $brand = Brand::findOrFail($request->id_brand);
            $brand->update([
                'overlay_color' => $request->overlay_color,
                'overlay_opacity' => $request->overlay_opacity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Saved successfully',
                'brand' => $brand
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
