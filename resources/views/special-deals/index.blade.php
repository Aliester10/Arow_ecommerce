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
                <div class="group">
                    <!-- Product Card with White Background and Enhanced Styling -->
                    <div class="bg-white rounded-xl lg:rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 lg:hover:-translate-y-2 overflow-hidden h-full flex flex-col">
                        <!-- Product Image Container -->
                        <div class="relative aspect-square overflow-hidden bg-gray-50 flex-shrink-0">
                            @if(isset($product) && $product->image_url)
                                <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->nama_produk }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </a>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-300 lg:text-gray-400 text-4xl lg:text-6xl"></i>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            @if($product->special_deal_discount)
                            <div class="absolute top-2 right-2 lg:top-4 lg:right-4 bg-red-500 text-white px-2 py-1 lg:px-3 lg:py-2 rounded-full text-[10px] lg:text-sm font-bold shadow-lg z-10">
                                {{ $product->special_deal_discount }}%
                            </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-3 lg:p-5 flex flex-col flex-grow">
                            <!-- Product Name -->
                            <h3 class="font-bold text-sm lg:text-xl text-gray-800 mb-2 lg:mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}" class="block text-gray-800 hover:text-orange-600 transition-colors">
                                    {{ $product->nama_produk }}
                                </a>
                            </h3>
                            
                            <!-- Price Section -->
                            <div class="space-y-1 mt-auto">
                                @if($product->special_deal_price)
                                    <div class="flex flex-wrap items-baseline gap-1 lg:gap-2">
                                        <span class="text-sm lg:text-2xl font-bold text-red-600 whitespace-nowrap">
                                            Rp {{ number_format($product->special_deal_price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] lg:text-base text-gray-400 line-through whitespace-nowrap">
                                            Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm lg:text-2xl font-bold text-gray-800 whitespace-nowrap">
                                        Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Add to Cart Button -->
                            <button onclick="addToCart({{ $product->id_produk }}, 1)" 
                                    class="mt-3 lg:mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 lg:py-3 px-2 lg:px-4 rounded-lg lg:rounded-xl text-xs lg:text-base transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center justify-center gap-1 lg:gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
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