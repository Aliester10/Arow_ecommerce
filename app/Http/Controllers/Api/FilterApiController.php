<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Produk;

class FilterApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'brands' => Brand::orderBy('nama_brand')->get(['id_brand', 'nama_brand']),
            'price_range' => [
                'min' => Produk::min('harga_produk'),
                'max' => Produk::max('harga_produk'),
            ],
        ]);
    }
}
