<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\SliderBanner;
use App\Models\Kategori;
use App\Models\Brand;
use App\Models\IntegratedSolution;
use App\Models\IntegratedSolutionCategory;
use App\Models\PromoCampaign;

class HomeController extends Controller
{
    public function getTopBrandProducts($brandId)
    {
        $products = Produk::where('id_brand', $brandId)
            ->with(['brand', 'ulasan', 'images'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $brand = Brand::find($brandId);
        if ($brand) {
            $brand->append(['categories_count', 'products_count']);
        }

        return response()->json([
            'products' => $products,
            'brand' => $brand
        ]);
    }

    public function index()
    {
        $mainBanners = SliderBanner::where('active', true)->orderBy('position')->get();
        $kategoris = Kategori::all();
        $products = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'ulasan', 'images'])->inRandomOrder()->take(6)->get();
        $brands = Brand::all();

        // Get integrated solutions data
        $integratedSolution = IntegratedSolution::where('is_active', true)->first();
        $integratedCategories = [];

        if ($integratedSolution) {
            $solutionCategories = IntegratedSolutionCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            $integratedCategories = $solutionCategories->filter(function ($category) {
                return $category->kategori_id;
            })->map(function ($category) {
                $kategori = Kategori::find($category->kategori_id);
                if (!$kategori) {
                    return null;
                }

                return [
                    'category' => $kategori,
                    'image' => $category->category_image,
                    'subcategories' => $kategori->subkategori()->inRandomOrder()->limit(4)->get()
                ];
            })->filter();
        }

        // Get active promo campaigns data
        $activePromos = PromoCampaign::where('status', 'aktif')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['products' => function ($query) {
                $query->where('status_produk', 'aktif');
            }])
            ->get();

        // Get in-house brands data
        $inHouseBrandNames = ['ABE living', 'ABE edu', 'aro baskara esa living', 'aro  baskara esa living', 'aro baskara esa education', 'aro  baskara esa education'];
        $inHouseBrands = Brand::whereIn('nama_brand', $inHouseBrandNames)->get();

        $inHouseBrandsWithProducts = [];
        foreach ($inHouseBrands as $brand) {
            $brandProducts = Produk::where('id_brand', $brand->id_brand)
                ->where('status_produk', 'aktif')
                ->with(['brand', 'ulasan', 'images'])
                ->inRandomOrder()
                ->take(6)
                ->get();

            if ($brandProducts->count() > 0) {
                $inHouseBrandsWithProducts[] = [
                    'brand' => $brand,
                    'products' => $brandProducts
                ];
            }
        }

        // Get top brands data (excluding in-house brands)
        // Show all brands with logos, even without products
        $topBrands = Brand::whereNotIn('nama_brand', $inHouseBrandNames)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $topBrands->each(function($brand) {
            $brand->append(['categories_count', 'products_count']);
        });

        // Get first brand's products as default
        $topBrandProducts = [];
        $selectedTopBrand = null;

        if ($topBrands->count() > 0) {
            $selectedTopBrand = $topBrands->first();
            $selectedTopBrand->append(['categories_count', 'products_count']);
            $topBrandProducts = Produk::where('id_brand', $selectedTopBrand->id_brand)
                ->with(['brand', 'ulasan', 'images'])
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        return view('home', compact('mainBanners', 'kategoris', 'products', 'brands', 'integratedSolution', 'integratedCategories', 'activePromos', 'inHouseBrandsWithProducts', 'topBrands', 'topBrandProducts', 'selectedTopBrand'));
    }
}