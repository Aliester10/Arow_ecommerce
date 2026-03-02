<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Brand;
use App\Models\Subkategori;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan', 'images']);

        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->whereHas('subSubkategori', function ($q) use ($request) {
                $q->where('nama_sub_subkategori', $request->category);
            })
                ->orWhereHas('subSubkategori.subkategori', function ($q) use ($request) {
                    $q->where('nama_subkategori', $request->category);
                })
                ->orWhereHas('subSubkategori.subkategori.kategori', function ($q) use ($request) {
                    $q->where('nama_kategori', $request->category);
                });
        }

        // Brand filtering
        if ($request->has('brands') && is_array($request->brands)) {
            $query->whereIn('id_brand', $request->brands);
        }

        // Price range filtering
        if ($request->has('min_price') && $request->min_price) {
            $query->where('harga_produk', '>=', (int)str_replace(['.', ','], '', $request->min_price));
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('harga_produk', '<=', (int)str_replace(['.', ','], '', $request->max_price));
        }

        $products = $query->paginate(12);
        $categories = Kategori::all();
        $brands = Brand::orderBy('nama_brand')->get();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan.user', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Produk::with(['ulasan', 'images'])
            ->where('id_sub_subkategori', $product->id_sub_subkategori)
            ->where('id_produk', '!=', $product->id_produk)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
