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
            'logo_brand' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'logo_brand' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo_brand', 'gambar_background']);

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

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil dihapus!');
    }
}
