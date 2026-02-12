@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Quotation</h1>
        <a href="{{ route('orders.show', $order->id_order) }}" class="text-sm text-gray-600 hover:text-orange-600 flex items-center">
            <i class="fas fa-receipt mr-2"></i> Lihat Detail Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <div class="text-sm text-gray-500">Order ID</div>
                        <div class="text-lg font-bold text-gray-800">#{{ $order->id_order }}</div>
                        <div class="mt-4 text-sm text-gray-600">
                            <div class="font-semibold text-gray-800 mb-1">Informasi</div>
                            <div>Permintaan quotation kamu sudah dibuat. Tim kami akan memproses penawaran sebelum pembayaran.</div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-sm text-gray-500">Total Tagihan</div>
                        <div class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-400 mt-1">Status Quotation: {{ strtoupper($order->quotation->status_quotation ?? 'DRAFT') }}</div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-500">ID Quotation</div>
                        <div class="font-bold text-gray-800">{{ $order->quotation->id_quotation ?? '-' }}</div>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <div class="text-sm text-gray-500">Status Pesanan</div>
                        <div class="font-bold text-gray-800">{{ $order->status_order }}</div>
                    </div>
                </div>

                <div class="mt-4 text-xs text-gray-500">
                    Kamu bisa menunggu hingga quotation dikirim/di-update oleh admin.
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700">
                    Produk Pesanan
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-800">{{ $item->produk->nama_produk }}</div>
                                <div class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="font-bold text-gray-800">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Alamat Pengiriman</h3>
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="font-semibold text-gray-800">{{ $order->shipping_name }}</div>
                    <div>{{ $order->shipping_phone }}</div>
                    <div class="whitespace-pre-line">{{ $order->shipping_address }}</div>
                    <div>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postcode }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
