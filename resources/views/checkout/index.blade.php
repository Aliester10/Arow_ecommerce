@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Billing & Shipping Details (Mockup for now as we use user data) -->
        <div class="w-full lg:w-3/5">
             <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Alamat Pengiriman</h3>
                <div class="text-sm text-gray-600 mb-4">
                    <p class="font-bold text-gray-800">{{ Auth::user()->nama_user }}</p>
                    <p class="mt-1">{{ Auth::user()->email_user }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                        <input type="text" name="shipping_name" form="checkout-form" value="{{ old('shipping_name', Auth::user()->nama_user) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" required>
                        @error('shipping_name')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP</label>
                        <input type="text" name="shipping_phone" form="checkout-form" value="{{ old('shipping_phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" placeholder="08xxxxxxxxxx" required>
                        @error('shipping_phone')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="shipping_address" form="checkout-form" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kota/Kabupaten</label>
                        <input type="text" name="shipping_city" form="checkout-form" value="{{ old('shipping_city') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" required>
                        @error('shipping_city')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="shipping_province" form="checkout-form" value="{{ old('shipping_province') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" required>
                        @error('shipping_province')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="shipping_postcode" form="checkout-form" value="{{ old('shipping_postcode') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500" required>
                        @error('shipping_postcode')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
             </div>

             <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                 <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Metode Pembayaran</h3>
                 <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST">
                     @csrf
                     <div class="space-y-3">
                         @php
                             $selected = $selectedMethod ?? null;
                             $defaultMethod = in_array($selected, ['transfer', 'qris', 'quotation'], true) ? $selected : 'transfer';
                         @endphp
                         <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                             <input type="radio" name="payment_method" value="transfer" class="form-radio text-orange-600 focus:ring-orange-500" {{ $defaultMethod === 'transfer' ? 'checked' : '' }}>
                             <div class="flex-1">
                                 <span class="block font-medium text-gray-800">Bank Transfer</span>
                                 <span class="block text-xs text-gray-500">BCA, Mandiri, BNI, BRI</span>
                             </div>
                             <i class="fas fa-university text-gray-400"></i>
                         </label>

                         <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                             <input type="radio" name="payment_method" value="qris" class="form-radio text-orange-600 focus:ring-orange-500" {{ $defaultMethod === 'qris' ? 'checked' : '' }}>
                             <div class="flex-1">
                                 <span class="block font-medium text-gray-800">QRIS</span>
                                 <span class="block text-xs text-gray-500">Langsung bayar menggunakan QRIS</span>
                             </div>
                             <i class="fas fa-qrcode text-gray-400"></i>
                         </label>

                         <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                             <input type="radio" name="payment_method" value="quotation" class="form-radio text-orange-600 focus:ring-orange-500" {{ $defaultMethod === 'quotation' ? 'checked' : '' }}>
                             <div class="flex-1">
                                 <span class="block font-medium text-gray-800">Quotation</span>
                                 <span class="block text-xs text-gray-500">Ajukan penawaran (quotation) sebelum bayar</span>
                             </div>
                             <i class="fas fa-file-invoice text-gray-400"></i>
                         </label>

                         <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                             <input type="radio" name="payment_method" value="credit_card" class="form-radio text-orange-600 focus:ring-orange-500" disabled>
                             <div class="flex-1">
                                 <span class="block font-medium text-gray-400">Kartu Kredit (Segera Hadir)</span>
                             </div>
                             <i class="fas fa-credit-card text-gray-300"></i>
                         </label>
                         <!-- Add more methods -->
                     </div>
                 </form>
             </div>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-2/5">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                
                <ul class="divide-y divide-gray-100 mb-4 max-h-64 overflow-y-auto pr-2">
                    @foreach($cart->details as $detail)
                        <li class="py-3 flex justify-between text-sm">
                            <div class="flex items-center">
                                <span class="bg-gray-100 text-gray-500 w-6 h-6 rounded flex items-center justify-center text-xs mr-2">{{ $detail->qty_cart }}x</span>
                                <span class="text-gray-600 line-clamp-1">{{ $detail->produk->nama_produk }}</span>
                            </div>
                            <span class="font-medium text-gray-800">Rp {{ number_format($detail->harga * $detail->qty_cart, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm text-gray-600 mb-6">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkos Kirim</span>
                        <span class="text-green-600 font-medium">Gratis</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-orange-600 border-t border-gray-100 pt-2 mt-2">
                        <span>Total Tagihan</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button onclick="document.getElementById('checkout-form').submit()" class="block w-full text-center bg-orange-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-700 transition">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
