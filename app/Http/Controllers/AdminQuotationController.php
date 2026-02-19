<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminQuotationController extends Controller
{
    public function edit($orderId)
    {
        $order = Order::query()
            ->with(['items.produk', 'payment', 'quotation.items'])
            ->findOrFail($orderId);

        if (($order->payment->metode ?? null) !== 'quotation') {
            abort(404);
        }

        $quotation = $order->quotation;
        if (!$quotation) {
            $quotation = Quotation::create([
                'id_order' => $order->id_order,
                'status_quotation' => 'draft',
            ]);
            $order->setRelation('quotation', $quotation);
        }

        if ($quotation->items()->count() === 0) {
            foreach ($order->items as $idx => $item) {
                QuotationItem::create([
                    'id_quotation' => $quotation->id_quotation,
                    'id_produk' => $item->id_produk,
                    'product_name' => $item->produk->nama_produk ?? null,
                    'qty' => (int) $item->qty,
                    'price' => (float) $item->price,
                    'description' => null,
                    'sort_order' => $idx,
                ]);
            }
            $quotation->load('items');
        }

        return view('admin.quotations.edit', compact('order', 'quotation'));
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::query()
            ->with(['payment', 'quotation.items'])
            ->findOrFail($orderId);

        if (($order->payment->metode ?? null) !== 'quotation') {
            abort(404);
        }

        $quotation = $order->quotation;
        if (!$quotation) {
            abort(404);
        }

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:quotation_items,id',
            'items.*.product_name' => 'nullable|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string|max:2000',
        ]);

        $allowedIds = $quotation->items()->pluck('id')->all();

        foreach ($validated['items'] as $row) {
            if (!in_array((int) $row['id'], $allowedIds, true)) {
                continue;
            }

            QuotationItem::query()
                ->where('id', $row['id'])
                ->update([
                    'product_name' => $row['product_name'] ?? null,
                    'qty' => (int) $row['qty'],
                    'price' => (float) $row['price'],
                    'description' => $row['description'] ?? null,
                ]);
        }

        return redirect()->route('admin.quotations.edit', $order->id_order)->with('success', 'Quotation berhasil diperbarui.');
    }

    public function downloadExcel($orderId)
    {
        $order = Order::query()
            ->with(['items.produk', 'quotation.items', 'payment'])
            ->findOrFail($orderId);

        if (($order->payment->metode ?? null) !== 'quotation') {
            abort(404);
        }

        $filename = 'quotation_order_' . $order->id_order . '.xls';

        $response = new StreamedResponse(function () use ($order) {
            $quotationItems = $order->quotation?->items ?? collect();

            $rows = $quotationItems->count() > 0
                ? $quotationItems
                : $order->items;

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
}
