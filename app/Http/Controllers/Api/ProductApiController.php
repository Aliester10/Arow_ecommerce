<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Return products with optional filtering.
     * Supported query parameters:
     *   - brands[] (array of brand IDs)
     *   - min_price, max_price
     *   - category (category name)
     *   - since (YYYY-MM-DD HH:MM:SS) for delta sync
     */
    public function index(Request $request)
    {
        $query = Produk::with(['brand', 'subSubkategori.subkategori.kategori', 'images']);

        // Brand filter
        if ($request->filled('brands')) {
            $query->whereIn('id_brand', $request->brands);
        }
        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('harga_produk', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga_produk', '<=', $request->max_price);
        }
        // Category filter (matches any level of hierarchy)
        if ($request->filled('category')) {
            $cat = $request->category;
            $query->whereHas('subSubkategori.subkategori.kategori', function ($q) use ($cat) {
                $q->where('nama_kategori', $cat);
            });
        }
        // Delta sync
        if ($request->filled('since')) {
            $query->where('updated_at', '>', $request->query('since'));
        }

        return response()->json($query->get());
    }
}
