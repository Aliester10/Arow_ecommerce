@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if($cart && $cart->details->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="w-full lg:w-3/4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 tex-gray-500 text-sm uppercase">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Produk</th>
                                    <th class="px-6 py-3 font-medium text-center">Harga</th>
                                    <th class="px-6 py-3 font-medium text-center">Jumlah</th>
                                    <th class="px-6 py-3 font-medium text-center">Total</th>
                                    <th class="px-6 py-3 font-medium text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($cart->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-16 w-16 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden border border-gray-200 flex items-center justify-center mr-4">
                                                    <i class="fas fa-box text-gray-400 text-2xl"></i>
                                                </div>
                                                <div>
                                                    <a href="{{ route('products.show', $detail->produk->slug) }}"
                                                        class="font-medium text-gray-800 hover:text-orange-600 line-clamp-1">
                                                        {{ $detail->produk->nama_produk }}
                                                    </a>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $detail->produk->brand->nama_brand ?? 'Brand' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-600">
                                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('cart.update', $detail->id_cart_detail) }}" method="POST"
                                                class="inline-flex items-center border border-gray-300 rounded-md">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $detail->qty_cart }}" min="1"
                                                    class="w-12 text-center text-sm focus:outline-none border-none p-1"
                                                    onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-orange-600">
                                            Rp {{ number_format($detail->harga * $detail->qty_cart, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('cart.remove', $detail->id_cart_detail) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Belanja</h3>
                        <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                            <span>Total Harga ({{ $cart->details->sum('qty_cart') }} barang)</span>
                            <span>Rp
                                {{ number_format($cart->details->sum(function ($d) {
                return $d->harga * $d->qty_cart; }), 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-100 my-4"></div>
                        <div class="flex justify-between items-center mb-6 text-lg font-bold text-orange-600">
                            <span>Total Tagihan</span>
                            <span>Rp
                                {{ number_format($cart->details->sum(function ($d) {
                return $d->harga * $d->qty_cart; }), 0, ',', '.') }}</span>
                        </div>
                        <button type="button" id="checkoutBtn"
                            class="block w-full text-center bg-orange-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-700 transition">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>

            <div id="checkoutModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div id="checkoutModalBackdrop" class="absolute inset-0 bg-black/50"></div>
                <div class="relative min-h-full flex items-center justify-center p-4">
                    <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <div class="text-lg font-bold text-gray-800">Pilih Opsi Pembelian</div>
                            <div class="text-sm text-gray-500 mt-1">Silakan pilih metode yang kamu inginkan.</div>
                        </div>
                        <div class="p-5 space-y-3">
                            <a href="{{ route('checkout.index', ['method' => 'qris']) }}"
                                class="block w-full px-4 py-3 rounded-lg border border-orange-600 text-orange-600 font-bold hover:bg-orange-50 transition text-center">
                                Langsung Bayar (QRIS)
                            </a>
                            <a href="{{ route('checkout.index', ['method' => 'quotation']) }}"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition text-center">
                                Quotation
                            </a>
                            <button type="button" id="checkoutModalClose"
                                class="block w-full px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-100">
                <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-600 mb-2">Keranjang Belanja Kosong</h3>
                <p class="text-gray-500 mb-6">Yuk isi dengan barang-barang impianmu!</p>
                <a href="{{ route('home') }}"
                    class="inline-block px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('checkoutBtn');
            const modal = document.getElementById('checkoutModal');
            const closeBtn = document.getElementById('checkoutModalClose');
            const backdrop = document.getElementById('checkoutModalBackdrop');

            if (!btn || !modal) return;

            function openModal() {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }

            btn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
@endsection