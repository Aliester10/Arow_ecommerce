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
        $query = Produk::with(['brand', 'subkategori']);

        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->whereHas('subkategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->category); // Check subcategory name
            })->orWhereHas('subkategori.kategori', function($q) use ($request) {
                $q->where('nama_kategori', $request->category); // Check parent category name
            });
        }

        $products = $query->paginate(12);
        $categories = Kategori::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show($id)
    {
        $product = Produk::with(['brand', 'subkategori', 'ulasan.user'])->findOrFail($id);
        $relatedProducts = Produk::where('id_subkategori', $product->id_subkategori)
                                 ->where('id_produk', '!=', $id)
                                 ->take(4)
                                 ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
