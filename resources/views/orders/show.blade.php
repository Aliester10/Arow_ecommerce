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
                    @php
                        $quotationItems = (($order->payment->metode ?? null) === 'quotation')
                            ? ($order->quotation->items ?? collect())
                            : collect();
                        $rows = $quotationItems->count() > 0 ? $quotationItems : $order->items;
                    @endphp

                    @foreach($rows as $item)
                        @php
                            $isQuotationItem = isset($item->id_quotation);
                            $name = $isQuotationItem
                                ? ($item->product_name ?? ($item->product->nama_produk ?? '-'))
                                : ($item->produk->nama_produk ?? '-');
                            $qty = (int) ($item->qty ?? 0);
                            $price = (float) ($item->price ?? 0);
                            $desc = $isQuotationItem ? ($item->description ?? null) : null;
                        @endphp
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center mr-4">
                                   <i class="fas fa-box text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $name }}</div>
                                    <div class="text-sm text-gray-500">{{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }}</div>
                                    @if(!empty($desc))
                                        <div class="text-xs text-gray-500 mt-1">{{ $desc }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="font-bold text-gray-800">
                                Rp {{ number_format($qty * $price, 0, ',', '.') }}
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

                    @if(($order->payment->status ?? null) === 'failed' && !empty($order->payment->admin_note))
                        <div class="mt-6 p-4 rounded-lg border border-red-200 bg-red-50 text-red-700">
                            <div class="font-bold">Pembayaran Ditolak</div>
                            <div class="text-sm mt-1 whitespace-pre-line">{{ $order->payment->admin_note }}</div>
                        </div>
                    @endif

                    @if(($order->payment->metode ?? null) === 'quotation' && !empty($order->quotation))
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('checkout.quotation.download', $order->id_order) }}"
                                class="inline-flex items-center justify-center px-4 py-3 rounded-lg bg-orange-600 text-white font-bold hover:bg-orange-700 transition">
                                Download Quotation (Excel)
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if(($order->payment->metode ?? null) === 'transfer')
                <div id="instruksi-transfer" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700">
                        Instruksi Transfer
                    </div>
                    <div class="p-6 text-sm text-gray-700 space-y-4">
                        @php
                            $acc = $order->payment->paymentAccount;
                            $amountText = 'Rp ' . number_format($order->total_harga, 0, ',', '.');
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <div class="text-xs text-gray-500">Rekening Tujuan</div>
                                <div class="font-bold text-gray-900 mt-1">{{ $acc->bank_name ?? '-' }}</div>
                                <div class="mt-2 flex items-center justify-between gap-3">
                                    <div>
                                        <div class="text-xs text-gray-500">Nomor Rekening</div>
                                        <div id="account-number" class="font-semibold text-gray-900">{{ $acc->account_number ?? '-' }}</div>
                                    </div>
                                    <button type="button"
                                        onclick="navigator.clipboard.writeText(document.getElementById('account-number').innerText)"
                                        class="px-3 py-2 text-xs font-bold rounded-lg border border-orange-200 text-orange-600 hover:bg-orange-50">
                                        Salin
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <div class="text-xs text-gray-500">Nama Pemilik</div>
                                    <div class="font-semibold text-gray-900">{{ $acc->account_holder ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                                <div class="text-xs text-gray-500">Jumlah Transfer</div>
                                <div class="text-2xl font-extrabold text-orange-600 mt-1" id="transfer-amount">{{ $amountText }}</div>
                                <div class="mt-3">
                                    <button type="button"
                                        onclick="navigator.clipboard.writeText(document.getElementById('transfer-amount').innerText)"
                                        class="px-3 py-2 text-xs font-bold rounded-lg border border-orange-200 text-orange-600 hover:bg-orange-50">
                                        Salin Nominal
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">Pastikan nominal transfer sesuai total tagihan.</div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-100">
                            <div class="font-bold text-gray-900 mb-2">Upload Bukti Transfer</div>

                            @if(session('success'))
                                <div class="mb-3 p-3 text-green-700 bg-green-100 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="mb-3 p-3 text-red-700 bg-red-100 rounded-lg">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form action="{{ route('orders.uploadTransferProof', $order->id_order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="bukti_transfer" accept="image/*" required
                                    class="w-full rounded-md border border-gray-300 p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-gray-300 file:bg-gray-100 file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-orange-500" />
                                <button type="submit"
                                    class="mt-3 w-full inline-flex items-center justify-center px-4 py-3 rounded-lg bg-orange-600 text-white font-bold hover:bg-orange-700 transition">
                                    Upload Bukti Transfer
                                </button>
                            </form>

                            @if(!empty($order->payment->bukti_transfer))
                                <div class="mt-4">
                                    <div class="text-xs text-gray-500 mb-2">Bukti transfer yang sudah diupload</div>
                                    <a href="{{ asset('storage/' . $order->payment->bukti_transfer) }}" target="_blank" rel="noopener"
                                        class="block">
                                        <img src="{{ asset('storage/' . $order->payment->bukti_transfer) }}" alt="Bukti Transfer"
                                            class="w-full max-w-md rounded-lg border border-gray-200" />
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
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
                            <p class="text-sm font-bold text-gray-800">{{ (($order->payment->metode ?? null) === 'quotation') ? 'Quotation Selesai Dibuat' : 'Pembayaran Diterima' }}</p>
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

 
            </div>
        </div>
    </div>
</div>
@endsection
