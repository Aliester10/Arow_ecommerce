@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Order #{{ $order->id_order }}
            </h2>
            <div class="text-sm text-gray-500">
                Metode: {{ strtoupper($order->payment->metode ?? '-') }}
            </div>
        </div>
        <a href="{{ (($order->payment->metode ?? null) === 'quotation') ? route('admin.orders.quotation') : route('admin.orders.transfer') }}"
            class="text-sm text-gray-600 hover:text-primary flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden dark:bg-gray-800 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    Produk Pesanan
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">{{ $item->produk->nama_produk ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="font-bold text-gray-800 dark:text-white">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-lg font-bold dark:bg-gray-900 dark:border-gray-700">
                    <span class="dark:text-white">Total</span>
                    <span class="text-orange-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden dark:bg-gray-800 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    Informasi Pembayaran
                </div>
                <div class="p-6 text-sm text-gray-700 dark:text-gray-200 space-y-4">
                    @php
                        $payment = $order->payment;
                        $acc = $payment?->paymentAccount;
                        $paymentStatus = $payment->status ?? 'pending';
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-gray-500">Status Pembayaran</div>
                            <div class="font-bold">{{ strtoupper($paymentStatus) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Paid At</div>
                            <div class="font-bold">{{ optional($payment->paid_at)->format('d M Y H:i') ?? '-' }}</div>
                        </div>
                    </div>

                    @if(($payment->metode ?? null) === 'transfer')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                                <div class="text-xs text-gray-500">Rekening Tujuan</div>
                                <div class="font-bold mt-1">{{ $acc->bank_name ?? '-' }}</div>
                                <div class="mt-2 text-sm">{{ $acc->account_number ?? '-' }} ({{ $acc->account_holder ?? '-' }})</div>
                            </div>

                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                                <div class="text-xs text-gray-500">Bukti Transfer</div>
                                @if(!empty($payment->bukti_transfer))
                                    <a href="{{ asset('storage/' . $payment->bukti_transfer) }}" target="_blank" rel="noopener" class="block mt-2">
                                        <img src="{{ asset('storage/' . $payment->bukti_transfer) }}" class="w-full max-w-xs rounded border border-gray-200" alt="Bukti Transfer" />
                                    </a>
                                @else
                                    <div class="mt-2 text-sm text-gray-500">Belum ada bukti transfer.</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if(!empty($payment->admin_note))
                        <div class="p-4 rounded-lg border border-red-200 bg-red-50 text-red-700">
                            <div class="font-bold">Catatan Admin</div>
                            <div class="text-sm mt-1 whitespace-pre-line">{{ $payment->admin_note }}</div>
                        </div>
                    @endif

                    @if(($payment->metode ?? null) === 'transfer')
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="font-bold mb-2">Konfirmasi Pembayaran</div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <form action="{{ route('admin.orders.approve', $order->id_order) }}" method="POST" onsubmit="return confirm('Approve pembayaran untuk order ini?');">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white font-bold hover:bg-green-700">Approve</button>
                                </form>

                                <form action="{{ route('admin.orders.reject', $order->id_order) }}" method="POST" onsubmit="return confirm('Reject pembayaran untuk order ini? Pastikan alasan sudah diisi.');" class="flex-1">
                                    @csrf
                                    <textarea name="admin_note" rows="2" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                        placeholder="Alasan penolakan (wajib)">{{ old('admin_note') }}</textarea>
                                    @error('admin_note')
                                        <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                    <button type="submit" class="mt-2 px-4 py-2 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700">Reject</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24 dark:bg-gray-800 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">Customer</h3>
                <div class="text-sm text-gray-600 dark:text-gray-200 space-y-1">
                    <div class="font-semibold text-gray-800 dark:text-white">{{ $order->user->nama_user ?? '-' }}</div>
                    <div>{{ $order->user->email_user ?? '-' }}</div>
                </div>

                <h3 class="font-bold text-gray-800 dark:text-white mt-6 mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">Alamat Pengiriman</h3>
                <div class="text-sm text-gray-600 dark:text-gray-200 space-y-1">
                    <div class="font-semibold text-gray-800 dark:text-white">{{ $order->shipping_name ?? '-' }}</div>
                    <div>{{ $order->shipping_phone ?? '-' }}</div>
                    <div class="whitespace-pre-line">{{ $order->shipping_address ?? '-' }}</div>
                    <div>{{ $order->shipping_city ?? '-' }}, {{ $order->shipping_province ?? '-' }} {{ $order->shipping_postcode ?? '-' }}</div>
                </div>

                @if(($order->payment->metode ?? null) === 'quotation')
                    <div class="mt-6">
                        <a href="{{ route('checkout.quotation.download', $order->id_order) }}" class="w-full inline-flex items-center justify-center px-4 py-2 rounded-lg bg-orange-600 text-white font-bold hover:bg-orange-700">
                            Download Quotation (Excel)
                        </a>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.quotations.edit', $order->id_order) }}" class="w-full inline-flex items-center justify-center px-4 py-2 rounded-lg bg-primary text-white font-bold hover:bg-opacity-90">
                            Edit Quotation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
