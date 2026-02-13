@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 sm:px-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-gray-100 flex items-center justify-between">
                <h1 class="text-lg sm:text-xl font-bold text-gray-800">Favorit Saya</h1>
                <a href="{{ route('products.index') }}"
                    class="text-orange-600 font-medium text-sm hover:text-orange-700">Lanjut Belanja</a>
            </div>

            @if(session('success'))
                <div class="px-4 sm:px-6 pt-4">
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-6">
                @if($wishlists->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($wishlists as $item)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
                                <a href="{{ route('products.show', $item->produk->id_produk) }}" class="block">
                                    <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                                        @if($item->produk->gambar_produk && file_exists(public_path('storage/images/produk/' . $item->produk->gambar_produk)))
                                            <img src="{{ asset('storage/images/produk/' . $item->produk->gambar_produk) }}"
                                                alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('hitam-putih.svg') }}" alt="No Image"
                                                class="w-20 h-20 object-contain opacity-60">
                                        @endif
                                    </div>
                                </a>

                                <div class="p-4">
                                    <div class="text-xs text-gray-500 mb-1 line-clamp-1">
                                        {{ $item->produk->brand->nama_brand ?? 'Brand' }}
                                    </div>
                                    <a href="{{ route('products.show', $item->produk->id_produk) }}"
                                        class="block text-sm font-medium text-gray-800 hover:text-orange-600 line-clamp-2 min-h-[2.5rem]">
                                        {{ $item->produk->nama_produk }}
                                    </a>

                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('products.show', $item->produk->id_produk) }}"
                                            class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                                            Lihat
                                        </a>
                                        <form action="{{ route('wishlist.destroy', $item->produk->id_produk) }}" method="POST"
                                            class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-white rounded-lg border border-dashed border-gray-300">
                        <i class="far fa-heart text-5xl text-gray-300 mb-3"></i>
                        <h3 class="text-base font-medium text-gray-700">Wishlist kamu masih kosong</h3>
                        <p class="text-sm text-gray-500 mt-2">Tambahkan produk favorit kamu supaya gampang dicari lagi.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block mt-4 px-5 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm">
                            Lihat Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection