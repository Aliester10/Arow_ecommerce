<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderPaymentController extends Controller
{
    public function transferIndex()
    {
        $orders = Order::query()
            ->with(['user', 'items.produk', 'payment.paymentAccount'])
            ->whereHas('payment', function ($q) {
                $q->where('metode', 'transfer');
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.transfer_index', compact('orders'));
    }

    public function quotationIndex()
    {
        $orders = Order::query()
            ->with(['user', 'items.produk', 'payment', 'quotation'])
            ->whereHas('payment', function ($q) {
                $q->where('metode', 'quotation');
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.quotation_index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::query()
            ->with(['user', 'items.produk', 'payment.paymentAccount', 'quotation'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function approvePayment(Request $request, $id)
    {
        $order = Order::query()
            ->with(['payment'])
            ->findOrFail($id);

        if (!$order->payment) {
            abort(404);
        }

        $order->payment->status = 'paid';
        $order->payment->paid_at = now();
        $order->payment->rejected_at = null;
        $order->payment->admin_note = null;
        $order->payment->save();

        $order->status_order = 'paid';
        $order->save();

        return redirect()->route('admin.orders.show', $order->id_order)->with('success', 'Pembayaran berhasil di-approve.');
    }

    public function rejectPayment(Request $request, $id)
    {
        $order = Order::query()
            ->with(['payment'])
            ->findOrFail($id);

        if (!$order->payment) {
            abort(404);
        }

        $validated = $request->validate([
            'admin_note' => 'required|string|max:2000',
        ]);

        $order->payment->status = 'failed';
        $order->payment->rejected_at = now();
        $order->payment->admin_note = $validated['admin_note'];
        $order->payment->paid_at = null;
        $order->payment->save();

        if ($order->status_order === 'paid') {
            $order->status_order = 'pending';
            $order->save();
        }

        return redirect()->route('admin.orders.show', $order->id_order)->with('success', 'Pembayaran berhasil di-reject.');
    }
}
