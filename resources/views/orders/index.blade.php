@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Riwayat Pesanan</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 font-medium">ID Pesanan</th>
                            <th class="px-6 py-3 font-medium">Tanggal</th>
                            <th class="px-6 py-3 font-medium text-center">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Total</th>
                            <th class="px-6 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    #{{ $order->id_order }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $order->tanggal_order->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColor = match ($order->status_order) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ ucfirst($order->status_order) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-gray-800">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('orders.show', $order->id_order) }}"
                                        class="text-orange-600 hover:text-orange-800 font-medium text-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-100">
                <i class="fas fa-receipt text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-600 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Kamu belum pernah berbelanja di sini.</p>
                <a href="{{ route('home') }}"
                    class="inline-block px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection