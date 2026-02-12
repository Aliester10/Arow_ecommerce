<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();
        
        if (!$cart || $cart->details->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cart->details->sum(function($detail) {
            return $detail->harga * $detail->qty_cart;
        });

        $selectedMethod = $request->query('method');
        return view('checkout.index', compact('cart', 'total', 'selectedMethod'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,qris,quotation',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:255',
            'shipping_province' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:20',
        ]);

        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cart->details->sum(function($detail) {
            return $detail->harga * $detail->qty_cart; 
        });

        $orderId = null;
        $paymentMethod = $request->payment_method;

        DB::transaction(function () use ($cart, $total, $request, &$orderId, $paymentMethod) {
            // Create Order
            $order = Order::create([
                'id_user' => Auth::user()->id_user,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_province' => $request->shipping_province,
                'shipping_postcode' => $request->shipping_postcode,
                'tanggal_order' => now(),
                'total_harga' => $total,
                'status_order' => $paymentMethod === 'quotation' ? 'pending_quotation' : 'pending',
            ]);

            $orderId = $order->id_order;

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
                'metode' => $paymentMethod, // e.g., 'transfer'
                'amount' => $total,
                'status' => 'pending',
            ]);

            if ($paymentMethod === 'quotation') {
                Quotation::firstOrCreate(
                    ['id_order' => $order->id_order],
                    ['status_quotation' => 'draft']
                );
            }

            // Clear Cart (or mark as ordered)
            $cart->status = 'ordered'; 
            $cart->save();
            
            // Optionally create a new active cart for future use or delete details?
            // Usually we mark cart as 'ordered'
        });

        if ($paymentMethod === 'qris') {
            return redirect()->route('checkout.qris', $orderId);
        }

        if ($paymentMethod === 'quotation') {
            return redirect()->route('checkout.quotation', $orderId);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function qris($id)
    {
        $order = Order::with(['items.produk', 'payment'])->where('id_user', Auth::user()->id_user)->findOrFail($id);
        return view('checkout.qris', compact('order'));
    }

    public function quotation($id)
    {
        $order = Order::with(['items.produk', 'payment', 'quotation'])->where('id_user', Auth::user()->id_user)->findOrFail($id);
        if (!$order->quotation) {
            $order->quotation()->create(['status_quotation' => 'draft']);
            $order->load('quotation');
        }
        return view('checkout.quotation', compact('order'));
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
