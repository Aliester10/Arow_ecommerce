<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Banner;
use App\Models\Kategori;
use App\Models\Brand;
use App\Services\RuntimeTranslator;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $kategoris = Kategori::all();
        $products = Produk::with(['brand', 'subSubkategori.subkategori.kategori'])->inRandomOrder()->take(6)->get();
        $brands = Brand::all();
        
        // Get products grouped by brand (5 products per brand)
        $productsByBrand = [];
        foreach ($brands as $brand) {
            $productsByBrand[$brand->id_brand] = Produk::where('id_brand', $brand->id_brand)
                                                        ->with(['brand', 'subSubkategori.subkategori.kategori'])
                                                        ->inRandomOrder()
                                                        ->take(5)
                                                        ->get();
        }

        $translator = app(RuntimeTranslator::class);
        $productsByBrandForJs = [];

        foreach ($productsByBrand as $brandId => $items) {
            $productsByBrandForJs[$brandId] = $items->map(function ($p) use ($translator) {
                return [
                    'id_produk' => $p->id_produk,
                    'nama_produk' => $p->nama_produk,
                    'nama_produk_i18n' => $translator->translate($p->nama_produk),
                    'gambar_produk' => $p->gambar_produk,
                    'harga_produk' => $p->harga_produk,
                    'brand' => [
                        'id_brand' => $p->brand?->id_brand,
                        'nama_brand' => $p->brand?->nama_brand,
                        'nama_brand_i18n' => $translator->translate($p->brand?->nama_brand ?? ''),
                    ],
                ];
            })->values()->all();
        }

        return view('home', compact('banners', 'kategoris', 'products', 'brands', 'productsByBrand', 'productsByBrandForJs'));
    }
}
