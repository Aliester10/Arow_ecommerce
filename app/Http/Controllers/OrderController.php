<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        $paymentAccounts = PaymentAccount::query()
            ->where('is_active', true)
            ->orderBy('bank_name')
            ->orderBy('account_holder')
            ->get();

        $selectedMethod = $request->query('method');
        return view('checkout.index', compact('cart', 'total', 'selectedMethod', 'paymentAccounts'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:quotation,transfer',
            'payment_account_id' => 'nullable|integer|exists:payment_accounts,id',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:255',
            'shipping_province' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:20',
        ]);

        if ($request->payment_method === 'transfer' && empty($request->payment_account_id)) {
            return back()->withErrors([
                'payment_account_id' => 'Silakan pilih rekening tujuan untuk transfer bank.'
            ])->withInput();
        }

        $cart = Cart::with(['details.produk'])->where('id_user', Auth::user()->id_user)->where('status', 'active')->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $total = $cart->details->sum(function($detail) {
            return $detail->harga * $detail->qty_cart; 
        });

        $orderId = null;
        $paymentMethod = $request->payment_method;
        $paymentAccountId = $paymentMethod === 'transfer' ? $request->payment_account_id : null;

        DB::transaction(function () use ($cart, $total, $request, &$orderId, $paymentMethod, $paymentAccountId) {
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
                'payment_account_id' => $paymentAccountId,
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

        if ($paymentMethod === 'quotation') {
            return redirect()->route('checkout.quotation', $orderId);
        }

        if ($paymentMethod === 'transfer') {
            return redirect()->route('orders.show', $orderId)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan transfer bank.');
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function qris($id)
    {
        $order = Order::with(['items.produk', 'payment'])->where('id_user', Auth::user()->id_user)->findOrFail($id);

        $perusahaan = Perusahaan::query()->first();
        $rawNumber = (string) ($perusahaan->notelp_perusahaan ?? $perusahaan->phone_alt ?? '');
        $waNumber = preg_replace('/\D+/', '', $rawNumber);

        $waUrl = null;
        if (!empty($waNumber)) {
            $waMessage = "Halo Admin, saya ingin melakukan pembayaran untuk pesanan #{$order->id_order}. Total tagihan: Rp " . number_format($order->total_harga, 0, ',', '.') . ".";
            $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waMessage);
        }

        return view('checkout.qris', compact('order', 'waUrl', 'waNumber'));
    }

    public function quotation($id)
    {
        $order = Order::with(['items.produk', 'payment', 'quotation.items'])->where('id_user', Auth::user()->id_user)->findOrFail($id);
        if (!$order->quotation) {
            $order->quotation()->create(['status_quotation' => 'draft']);
            $order->load('quotation.items');
        }
        return view('checkout.quotation', compact('order'));
    }

    public function downloadQuotationExcel($id)
    {
        $order = Order::with(['items.produk', 'quotation.items', 'payment'])
            ->where('id_user', Auth::user()->id_user)
            ->findOrFail($id);

        if (($order->payment->metode ?? null) !== 'quotation') {
            abort(404);
        }

        $filename = 'quotation_order_' . $order->id_order . '.xls';

        $response = new StreamedResponse(function () use ($order) {
            $total = 0;

            $quotationItems = $order->quotation?->items ?? collect();
            $rows = $quotationItems->count() > 0 ? $quotationItems : $order->items;

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

            foreach ($rows as $idx => $item) {
                $qty = (int) ($item->qty ?? 0);
                $price = (float) ($item->price ?? 0);
                $subtotal = $qty * $price;
                $total += $subtotal;

                $name = $item instanceof QuotationItem
                    ? ($item->product_name ?? ($item->product?->nama_produk ?? '-'))
                    : ($item->produk->nama_produk ?? '-');

                $desc = $item instanceof QuotationItem ? ($item->description ?? '') : '';

                echo "<tr>";
                echo "<td>" . ($idx + 1) . "</td>";
                echo "<td>" . e($name) . "</td>";
                echo "<td>" . e($qty) . "</td>";
                echo "<td>" . number_format($price, 0, ',', '.') . "</td>";
                echo "<td>" . number_format($subtotal, 0, ',', '.') . "</td>";
                echo "<td>" . e($desc) . "</td>";
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
        $order = Order::with(['items.produk', 'payment.paymentAccount', 'quotation.items'])
            ->where('id_user', Auth::user()->id_user)
            ->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function uploadTransferProof(Request $request, $id)
    {
        $order = Order::with(['payment'])->where('id_user', Auth::user()->id_user)->findOrFail($id);

        if (($order->payment->metode ?? null) !== 'transfer') {
            abort(404);
        }

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $payment = $order->payment;
        if (!$payment) {
            abort(404);
        }

        if (!empty($payment->bukti_transfer)) {
            Storage::disk('public')->delete($payment->bukti_transfer);
        }

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        $payment->bukti_transfer = $path;
        $payment->save();

        return redirect()->route('orders.show', $order->id_order)->with('success', 'Bukti transfer berhasil diupload.');
    }
}
