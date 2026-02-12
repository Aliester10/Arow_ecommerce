<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Brand;
use App\Models\Banner;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productCount = Produk::count();
        $brandCount = Brand::count();
        $bannerCount = Banner::count();

        return view('admin.dashboard', compact('productCount', 'brandCount', 'bannerCount'));
    }
}
