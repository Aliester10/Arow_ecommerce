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
        $query = Produk::with(['brand', 'subSubkategori.subkategori.kategori']);

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

        $products = $query->paginate(12);
        $categories = Kategori::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show($id)
    {
        $product = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan.user'])->findOrFail($id);
        $relatedProducts = Produk::where('id_sub_subkategori', $product->id_sub_subkategori)
                                 ->where('id_produk', '!=', $id)
                                 ->take(4)
                                 ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
