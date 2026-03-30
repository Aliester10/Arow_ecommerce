<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Kategori::with(['subkategori.subSubkategori'])->get();
        return response()->json($categories);
    }
}
