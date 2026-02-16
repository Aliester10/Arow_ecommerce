<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $slug)
    {
        $request->validate([
            'rating_ulasan' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar_ulasan' => ['nullable', 'string'],
        ]);

        $product = Produk::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        Ulasan::create([
            'id_produk' => $product->id_produk,
            'id_user' => $user->id_user,
            'rating_ulasan' => $request->rating_ulasan,
            'komentar_ulasan' => $request->komentar_ulasan,
            'tanggal_ulasan' => now(),
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }
}
