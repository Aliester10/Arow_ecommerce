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
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 lg:gap-6 gap-3 sm:gap-4">
                        @foreach($wishlists as $item)
                            <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300 relative group"
                                data-skeleton-container>
                                <!-- Delete Button Overlay -->
                                <form action="{{ route('wishlist.destroy', $item->produk->id_produk) }}" method="POST"
                                    class="absolute top-2 right-2 z-40 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 bg-white/90 rounded-full shadow-md text-red-500 hover:text-red-700 hover:bg-white flex items-center justify-center transition-colors"
                                        title="Hapus dari Favorit">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>

                                <a href="{{ route('products.show', $item->produk->slug) }}" class="flex flex-col h-full">
                                    <!-- Product Image -->
                                    <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                                        @if(isset($item->produk) && $item->produk->image_url)
                                            <div data-skeleton
                                                class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0"
                                                style="z-index: 30;"></div>
                                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                                <img src="{{ $item->produk->image_url }}" alt="{{ $item->produk->nama_produk }}"
                                                    class="w-full h-full object-contain p-2" data-skeleton-image loading="lazy">
                                            </div>
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center bg-gray-50"
                                                style="z-index: 10;">
                                                <i class="fas fa-image text-gray-300 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex flex-col flex-grow p-3 bg-white">
                                        <!-- Product Name -->
                                        <h3
                                            class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                            {{ $item->produk->nama_produk }}
                                        </h3>

                                        <!-- Price Section -->
                                        <div class="mt-auto">
                                            <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                            @if($item->produk->harga_diskon && $item->produk->harga_diskon < $item->produk->harga_produk)
                                                <span class="text-[15px] font-bold text-[#eab308]">
                                                    Rp {{ number_format($item->produk->harga_diskon, 0, ',', '.') }},00
                                                </span>
                                            @else
                                                <span class="text-[15px] font-bold text-[#eab308]">
                                                    Rp {{ number_format($item->produk->harga_produk, 0, ',', '.') }},00
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Seller Info -->
                                        <div class="mt-3 flex flex-col gap-1">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                                <span
                                                    class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $item->produk->asal_produk ?: 'Indonesia' }}</span>
                                            </div>
                                            <div class="text-[11px] text-gray-400 line-clamp-1">
                                                PT Ayo Belanja Nusantara
                                            </div>
                                        </div>
                                    </div>
                                </a>
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