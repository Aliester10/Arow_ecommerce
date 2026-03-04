@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 sm:px-4 py-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                {{ $specialDeal->title }}
            </h1>
            @if($specialDeal->subtitle)
                <p class="text-lg text-gray-600">
                    {{ $specialDeal->subtitle }}
                </p>
            @endif
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <div
                    class="flex flex-col h-full bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden shadow-md group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full">
                        <!-- Product Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-white shrink-0">
                            @if(isset($product) && $product->image_url)
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->nama_produk }}"
                                        class="object-contain max-w-full max-h-full transition-transform duration-300 group-hover:scale-110"
                                        loading="lazy">
                                </div>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                    <i class="fas fa-image text-gray-300 text-2xl sm:text-3xl"></i>
                                </div>
                            @endif

                            <!-- Discount Badge -->
                            @if($product->special_deal_discount)
                                <div
                                    class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold z-20">
                                    Diskon {{ $product->special_deal_discount }}%
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex flex-col flex-grow p-3 sm:p-4 bg-white">
                            <!-- Product Name -->
                            <h3
                                class="text-sm sm:text-base font-semibold text-gray-800 mb-2 sm:mb-3 line-clamp-2 leading-tight">
                                {{ $product->nama_produk }}
                            </h3>

                            <!-- Price Section -->
                            <div class="flex flex-col mt-auto">
                                @if($product->special_deal_price)
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                        <span class="text-base sm:text-lg font-bold text-red-600">
                                            Rp. {{ number_format($product->special_deal_price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs sm:text-sm text-gray-400 line-through">
                                            Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-base sm:text-lg font-bold text-gray-800">
                                        Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Cart Button -->
                            <div class="mt-3">
                                <button onclick="addToCart({{ $product->id_produk }}, 1)"
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 sm:py-2.5 rounded-lg transition-colors text-sm sm:text-base">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div
                    class="col-span-2 sm:col-span-3 lg:col-span-4 w-full text-center py-12 sm:py-16 bg-white rounded-lg sm:rounded-xl border border-dashed border-gray-300">
                    <i class="fas fa-box-open text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                    <p class="text-gray-500 font-medium text-lg">Tidak ada produk special deals tersedia.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection