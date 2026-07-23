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
        $idVariant = $request->input('id_variant');
        
        $price = $product->promo_price ?? $product->harga_produk;
        if ($idVariant) {
            $variant = \App\Models\ProductVariant::find($idVariant);
            if ($variant) {
                $price = $variant->harga_produk;
            }
        }

        $cart = Cart::firstOrCreate(
            ['id_user' => Auth::user()->id_user, 'status' => 'active']
        );

        $cartDetail = CartDetail::where('id_cart', $cart->id_cart)
            ->where('id_produk', $product->id_produk)
            ->when($idVariant, function($query) use ($idVariant) {
                return $query->where('id_product_variant', $idVariant);
            }, function($query) {
                return $query->whereNull('id_product_variant');
            })
            ->first();

        if ($cartDetail) {
            $cartDetail->qty_cart += $request->input('quantity', 1);
            $cartDetail->harga = $price; // Update price if changed
            $cartDetail->save();
        } else {
            $cartDetail = CartDetail::create([
                'id_cart' => $cart->id_cart,
                'id_produk' => $product->id_produk,
                'id_product_variant' => $idVariant,
                'qty_cart' => $request->input('quantity', 1),
                'harga' => $price
            ]);
        }

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.index', ['buy_now_item' => $cartDetail->id_cart_detail]);
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
