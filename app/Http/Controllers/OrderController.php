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
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            'payment_method' => 'required|in:qris,quotation',
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

    public function downloadQuotationExcel($id)
    {
        $order = Order::with(['items.produk', 'quotation', 'payment'])
            ->where('id_user', Auth::user()->id_user)
            ->findOrFail($id);

        if (($order->payment->metode ?? null) !== 'quotation') {
            abort(404);
        }

        $filename = 'quotation_order_' . $order->id_order . '.xls';

        $response = new StreamedResponse(function () use ($order) {
            $total = 0;

            echo "<html><head><meta charset=\"UTF-8\"></head><body>";
            echo "<table border=\"1\" cellpadding=\"6\" cellspacing=\"0\">";
            echo "<tr><th colspan=\"6\" style=\"font-size:16px;\">QUOTATION</th></tr>";
            echo "<tr><td><b>Order ID</b></td><td colspan=\"5\">#" . $order->id_order . "</td></tr>";
            echo "<tr><td><b>ID Quotation</b></td><td colspan=\"5\">" . ($order->quotation->id_quotation ?? '-') . "</td></tr>";
            echo "<tr><td><b>Tanggal</b></td><td colspan=\"5\">" . optional($order->tanggal_order)->format('Y-m-d H:i') . "</td></tr>";
            echo "<tr><td><b>Status Quotation</b></td><td colspan=\"5\">" . ($order->quotation->status_quotation ?? '-') . "</td></tr>";
            echo "<tr><td><b>Nama Penerima</b></td><td colspan=\"5\">" . e($order->shipping_name) . "</td></tr>";
            echo "<tr><td><b>No. HP</b></td><td colspan=\"5\">" . e($order->shipping_phone) . "</td></tr>";
            echo "<tr><td><b>Alamat</b></td><td colspan=\"5\">" . nl2br(e($order->shipping_address)) . "</td></tr>";
            echo "<tr><td><b>Kota/Provinsi/Kode Pos</b></td><td colspan=\"5\">" . e($order->shipping_city) . ", " . e($order->shipping_province) . " " . e($order->shipping_postcode) . "</td></tr>";
            echo "<tr><td colspan=\"6\"></td></tr>";

            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>Produk</th>";
            echo "<th>Qty</th>";
            echo "<th>Harga</th>";
            echo "<th>Subtotal</th>";
            echo "<th>Keterangan</th>";
            echo "</tr>";

            foreach ($order->items as $idx => $item) {
                $subtotal = (float) $item->qty * (float) $item->price;
                $total += $subtotal;

                echo "<tr>";
                echo "<td>" . ($idx + 1) . "</td>";
                echo "<td>" . e($item->produk->nama_produk ?? '-') . "</td>";
                echo "<td>" . e($item->qty) . "</td>";
                echo "<td>" . number_format((float) $item->price, 0, ',', '.') . "</td>";
                echo "<td>" . number_format($subtotal, 0, ',', '.') . "</td>";
                echo "<td></td>";
                echo "</tr>";
            }

            echo "<tr>";
            echo "<td colspan=\"4\" style=\"text-align:right;\"><b>Total</b></td>";
            echo "<td><b>" . number_format($total, 0, ',', '.') . "</b></td>";
            echo "<td></td>";
            echo "</tr>";

            echo "</table>";
            echo "</body></html>";
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
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
