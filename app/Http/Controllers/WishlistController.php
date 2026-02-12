<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $wishlists = Wishlist::with(['produk.brand'])
            ->where('id_user', $user->id_user)
            ->latest('id_wishlist')
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function store($id)
    {
        $user = Auth::user();

        Wishlist::firstOrCreate([
            'id_user' => $user->id_user,
            'id_produk' => $id,
        ]);

        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        Wishlist::where('id_user', $user->id_user)
            ->where('id_produk', $id)
            ->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
