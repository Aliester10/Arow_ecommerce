<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();
        
        if (!$cart || $cart->details->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cart->details->sum(function($detail) {
            return $detail->harga * $detail->qty_cart;
        });

        return view('checkout.index', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cart->details->sum(function($detail) {
            return $detail->harga * $detail->qty_cart; 
        });

        DB::transaction(function () use ($cart, $total, $request) {
            // Create Order
            $order = Order::create([
                'id_user' => Auth::user()->id_user,
                'tanggal_order' => now(),
                'total_harga' => $total,
                'status_order' => 'pending',
            ]);

            // Create Order Items
            foreach ($cart->details as $detail) {
                OrderItem::create([
                    'id_order' => $order->id_order,
                    'id_produk' => $detail->id_produk,
                    'qty' => $detail->qty_cart,
                    'price' => $detail->harga,
                ]);
            }

            // Create Payment
            Payment::create([
                'id_order' => $order->id_order,
                'metode' => $request->payment_method, // e.g., 'transfer'
                'amount' => $total,
                'status' => 'pending',
            ]);

            // Clear Cart (or mark as ordered)
            $cart->status = 'ordered'; 
            $cart->save();
            
            // Optionally create a new active cart for future use or delete details?
            // Usually we mark cart as 'ordered'
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('id_user', Auth::user()->id_user)->with('items.produk')->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['items.produk', 'payment'])->where('id_user', Auth::user()->id_user)->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
