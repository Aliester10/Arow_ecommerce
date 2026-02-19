<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Brand;
use App\Models\SliderBanner;
use App\Models\PromoBanner;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productCount = Produk::count();
        $brandCount = Brand::count();
        $bannerCount = SliderBanner::count() + PromoBanner::count();

        return view('admin.dashboard', compact('productCount', 'brandCount', 'bannerCount'));
    }
}
