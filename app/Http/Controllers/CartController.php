<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();
        
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        
        $cart = Cart::firstOrCreate(
            ['id_user' => Auth::user()->id_user, 'status' => 'active']
        );

        $cartDetail = CartDetail::where('id_cart', $cart->id_cart)
                                ->where('id_produk', $product->id_produk)
                                ->first();

        if ($cartDetail) {
            $cartDetail->qty_cart += $request->input('quantity', 1);
            $cartDetail->harga = $product->harga_produk; // Update price if changed
            $cartDetail->save();
        } else {
            CartDetail::create([
                'id_cart' => $cart->id_cart,
                'id_produk' => $product->id_produk, // Fixed: use id_produk
                'qty_cart' => $request->input('quantity', 1), // custom column name from migration
                'harga' => $product->harga_produk
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $cartDetail = CartDetail::findOrFail($id);
        $cartDetail->qty_cart = $request->input('quantity');
        $cartDetail->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function removeFromCart($id)
    {
        $cartDetail = CartDetail::findOrFail($id);
        $cartDetail->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }
}
