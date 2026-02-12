<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Produk;
use App\Models\SubSubkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function create()
    {
        $brands = Brand::all();
        // Load sub-subkategories with their parent subkategori and kategori for better display
        $subSubkategoris = SubSubkategori::with('subkategori.kategori')->get();

        return view('admin.products.create', compact('brands', 'subSubkategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_brand' => 'required|exists:brand,id_brand',
            'id_sub_subkategori' => 'required|exists:sub_subkategori,id_sub_subkategori',
            'harga_produk' => 'nullable|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'berat_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['harga_produk'] = $request->harga_produk ?? 0;

        if ($request->hasFile('gambar_produk')) {
            $image = $request->file('gambar_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Use Storage facade for better production compatibility
            Storage::disk('public')->putFileAs('images/produk', $image, $imageName);
            $data['gambar_produk'] = $imageName;
        }

        Produk::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function index()
    {
        $products = Produk::with(['brand', 'subSubkategori.subkategori.kategori'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        $brands = Brand::all();
        $subSubkategoris = SubSubkategori::with('subkategori.kategori')->get();

        return view('admin.products.edit', compact('product', 'brands', 'subSubkategoris'));
    }

    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_brand' => 'required|exists:brand,id_brand',
            'id_sub_subkategori' => 'required|exists:sub_subkategori,id_sub_subkategori',
            'harga_produk' => 'nullable|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'berat_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except(['gambar_produk']);
        $data['harga_produk'] = $request->harga_produk ?? $product->harga_produk;

        if ($request->hasFile('gambar_produk')) {
            // Delete old image using Storage
            if ($product->gambar_produk) {
                Storage::disk('public')->delete('images/produk/' . $product->gambar_produk);
            }

            $image = $request->file('gambar_produk');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images/produk', $image, $imageName);
            $data['gambar_produk'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);

        if ($product->gambar_produk) {
            Storage::disk('public')->delete('images/produk/' . $product->gambar_produk);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
