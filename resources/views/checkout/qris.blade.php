@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Pembayaran via WhatsApp</h1>
            <a href="{{ route('orders.show', $order->id_order) }}"
                class="text-sm text-gray-600 hover:text-orange-600 flex items-center">
                <i class="fas fa-receipt mr-2"></i> Lihat Detail Pesanan
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <div class="text-sm text-gray-500">ID Pesanan</div>
                            <div class="text-lg font-bold text-gray-800">#{{ $order->id_order }}</div>
                            <div class="mt-4 text-sm text-gray-600">
                                <div class="font-semibold text-gray-800 mb-1">Instruksi</div>
                                <div>Silakan lakukan pembayaran dengan menghubungi admin melalui WhatsApp.</div>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-500">Total Tagihan</div>
                            <div class="text-2xl font-bold text-orange-600">Rp
                                {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-400 mt-1">Status:
                                {{ strtoupper($order->payment->status ?? 'PENDING') }}</div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <div class="w-full max-w-sm border border-gray-200 rounded-xl p-6 bg-gray-50">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <div class="text-center">
                                    <i class="fab fa-whatsapp text-6xl text-green-500"></i>
                                    <div class="mt-3 text-sm text-gray-700 font-semibold">Lakukan pembayaran via WhatsApp</div>
                                    <div class="text-xs text-gray-500 mt-1">Klik tombol di bawah untuk mengirim pesan otomatis.</div>
                                </div>

                                <div class="mt-5">
                                    @if(!empty($waUrl))
                                        <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                                            class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                                            <i class="fab fa-whatsapp mr-2"></i> Hubungi via WhatsApp
                                        </a>
                                    @else
                                        <button type="button" disabled
                                            class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg bg-gray-300 text-gray-600 font-semibold cursor-not-allowed">
                                            <i class="fab fa-whatsapp mr-2"></i> Nomor WhatsApp belum diatur
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 text-xs text-gray-500 text-center">
                                Setelah kamu mengirim pesan dan pembayaran dikonfirmasi, status pesanan akan diperbarui.
                            </div>
                        </div>
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
                                    <div class="text-sm text-gray-500">{{ $item->qty }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-bold text-gray-800">Rp
                                    {{ number_format($item->qty * $item->price, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Alamat Pengiriman</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="font-semibold text-gray-800">{{ $order->shipping_name }}</div>
                        <div>{{ $order->shipping_phone }}</div>
                        <div class="whitespace-pre-line">{{ $order->shipping_address }}</div>
                        <div>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postcode }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection