<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\SliderBanner;
use App\Models\PromoBanner;
use App\Models\Kategori;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $mainBanners = SliderBanner::where('active', true)->orderBy('position')->get();
        $promoBanners = PromoBanner::with(['activePromoDetail'])->where('active', true)->get();
        $kategoris = Kategori::all();
        $products = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan'])->inRandomOrder()->take(6)->get();
        $brands = Brand::all();

        // Get products grouped by brand (5 products per brand)
        $productsByBrand = [];
        foreach ($brands as $brand) {
            $productsByBrand[$brand->id_brand] = Produk::where('id_brand', $brand->id_brand)
                ->with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan'])
                ->inRandomOrder()
                ->take(5)
                ->get();
        }

        return view('home', compact('mainBanners', 'promoBanners', 'kategoris', 'products', 'brands', 'productsByBrand'));
    }
}
