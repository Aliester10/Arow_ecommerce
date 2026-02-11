@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Detail Pesanan #{{ $order->id_order }}</h1>
        <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-orange-600 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Info & Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Items -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700">
                    Produk Pesanan
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center mr-4">
                                   <i class="fas fa-box text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $item->produk->nama_produk }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="font-bold text-gray-800">
                                Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-lg font-bold">
                    <span>Total Pesanan</span>
                    <span class="text-orange-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700">
                    Informasi Pembayaran
                </div>
                <div class="p-6 text-sm text-gray-600">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 mb-1">Metode</p>
                            <p class="font-medium text-gray-900 uppercase">{{ $order->payment->metode ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Status Pembayaran</p>
                            @php
                                $paymentStatus = $order->payment->status ?? 'pending';
                                $paymentColor = match($paymentStatus) {
                                    'pending' => 'text-yellow-600',
                                    'paid' => 'text-green-600',
                                    'failed' => 'text-red-600',
                                    default => 'text-gray-600'
                                };
                            @endphp
                            <p class="font-medium {{ $paymentColor }} uppercase">{{ $paymentStatus }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Status Pesanan</h3>
                
                <div class="relative pl-4 border-l-2 border-orange-200 space-y-8 my-4">
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-orange-600 h-4 w-4 rounded-full border-2 border-white box-content"></div>
                        <p class="text-sm font-bold text-gray-800">Pesanan Dibuat</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($order->status_order != 'pending')
                         <div class="relative">
                            <div class="absolute -left-[21px] bg-orange-600 h-4 w-4 rounded-full border-2 border-white box-content"></div>
                            <p class="text-sm font-bold text-gray-800">Pembayaran Diterima</p>
                             <p class="text-xs text-gray-500">Estimasi</p>
                        </div>
                    @endif
                     @if($order->status_order == 'completed')
                         <div class="relative">
                            <div class="absolute -left-[21px] bg-green-600 h-4 w-4 rounded-full border-2 border-white box-content"></div>
                            <p class="text-sm font-bold text-gray-800">Selesai</p>
                             <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                @if($order->status_order == 'pending')
                    <a href="#" class="block w-full text-center bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition mt-6">
                        Bayar Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
