@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 sm:px-4 py-8">

        <!-- Promo Banner & Header Section -->
        <div class="mb-8 md:mb-12">
            @if($promoCampaign->banner)
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-gray-100 mb-6">
                    <img src="{{ asset('storage/images/' . $promoCampaign->banner) }}" 
                         alt="{{ $promoCampaign->title }}" 
                         class="w-full h-auto object-cover max-h-96 md:max-h-110 lg:max-h-125 min-h-48">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent flex flex-col justify-end p-6 md:p-10 text-white">
                        <span class="inline-block bg-orange-600 text-white font-bold px-3 py-1 rounded-full text-xs uppercase mb-3 tracking-wider w-max shadow">
                            PROMO KAMPANYE
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-2 leading-tight drop-shadow-md">
                            {{ $promoCampaign->title }}
                        </h1>
                        @if($promoCampaign->subtitle)
                            <p class="text-lg sm:text-xl lg:text-2xl text-gray-200 mb-4 font-medium drop-shadow opacity-95">
                                {{ $promoCampaign->subtitle }}
                            </p>
                        @endif
                        <p class="text-xs sm:text-sm font-medium bg-white/20 inline-block px-3 py-1 rounded-md w-max">
                            <i class="far fa-calendar-alt mr-1"></i> Periode: {{ $promoCampaign->start_date->format('d M Y') }} s/d {{ $promoCampaign->end_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
            @else
                <!-- Fallback Styled Banner Card -->
                <div class="relative overflow-hidden rounded-2xl p-6 sm:p-10 lg:p-14 text-white shadow-xl mb-6"
                     style="background: linear-gradient(135deg, #FF3D00 0%, #FF9100 50%, #FFC400 100%);">
                    <div class="relative z-10 text-left max-w-4xl">
                        <span class="inline-block bg-white text-orange-600 font-bold px-3 py-1 rounded-full text-xs uppercase mb-3 tracking-wider shadow">
                            PROMO KAMPANYE
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold mb-2 leading-tight drop-shadow-lg">
                            {{ $promoCampaign->title }}
                        </h1>
                        @if($promoCampaign->subtitle)
                            <p class="text-lg sm:text-xl lg:text-3xl font-medium drop-shadow opacity-95 mb-6">
                                {{ $promoCampaign->subtitle }}
                            </p>
                        @endif
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-xs sm:text-sm font-semibold bg-black/20 px-3 py-1.5 rounded-md">
                                <i class="far fa-calendar-alt mr-1"></i> Periode: {{ $promoCampaign->start_date->format('d M Y') }} s/d {{ $promoCampaign->end_date->format('d M Y') }}
                            </span>
                            <span class="text-xs sm:text-sm font-semibold bg-green-600 px-3 py-1.5 rounded-md uppercase">
                                Status: {{ $promoCampaign->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    <!-- Decorative background elements -->
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-white/10 blur-xl"></div>
                    <div class="absolute -left-20 -top-20 w-60 h-60 rounded-full bg-white/10 blur-lg"></div>
                </div>
            @endif
            
            <!-- Description Block -->
            @if($promoCampaign->description)
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 dark:border-gray-700 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3">Tentang Promo Ini</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm sm:text-base">
                        {!! nl2br(e($promoCampaign->description)) !!}
                    </p>
                </div>
            @endif
        </div>

        <!-- Products Section Title -->
        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Produk yang Tergabung</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Dapatkan harga spesial diskon sebelum promo berakhir!</p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($promoCampaign->products as $product)
                @php
                    $discountType = $product->pivot->discount_type;
                    $discountValue = $product->pivot->discount_value;
                    
                    if ($discountType === 'percent') {
                        $promoPrice = $product->harga_produk * (1 - $discountValue / 100);
                        $discountLabel = '-' . round($discountValue) . '%';
                    } else {
                        $promoPrice = max(0, $product->harga_produk - $discountValue);
                        $discountLabel = '-Rp ' . number_format($discountValue, 0, ',', '.');
                    }
                @endphp
                <div class="group">
                    <!-- Product Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl lg:rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 lg:hover:-translate-y-2 overflow-hidden h-full flex flex-col border border-gray-100 dark:border-gray-700">
                        <!-- Product Image Container -->
                        <div class="relative aspect-square overflow-hidden bg-gray-50 dark:bg-gray-900 flex-shrink-0">
                            @if($product->image_url)
                                <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->nama_produk }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </a>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-300 dark:text-gray-500 lg:text-gray-400 text-4xl lg:text-6xl"></i>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-2 right-2 lg:top-4 lg:right-4 bg-red-500 text-white px-2 py-1 lg:px-3 lg:py-1.5 rounded-full text-[10px] lg:text-xs font-bold shadow-lg z-10">
                                {{ $discountLabel }}
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-3 lg:p-5 flex flex-col flex-grow">
                            <!-- Product Brand -->
                            @if($product->brand)
                                <span class="text-[10px] uppercase font-bold text-gray-400 mb-1 block">{{ $product->brand->nama_brand }}</span>
                            @endif

                            <!-- Product Name -->
                            <h3 class="font-bold text-sm lg:text-base text-gray-800 dark:text-white mb-2 line-clamp-2 group-hover:text-orange-500 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->nama_produk }}
                                </a>
                            </h3>
                            
                            <!-- Price Section -->
                            <div class="space-y-1 mt-auto">
                                <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 lg:gap-2">
                                    <span class="text-base lg:text-xl font-extrabold text-red-500 whitespace-nowrap">
                                        Rp {{ number_format($promoPrice, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs lg:text-sm text-gray-400 line-through whitespace-nowrap">
                                        Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Add to Cart Button -->
                            <button onclick="addToCart({{ $product->id_produk }}, 1)" 
                                    class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 lg:py-2.5 px-4 rounded-lg text-xs lg:text-sm transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Beli Sekarang</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 sm:col-span-3 lg:col-span-4 w-full text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 shadow-sm">
                    <i class="fas fa-box-open text-gray-300 dark:text-gray-600 text-6xl mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-lg">Tidak ada produk yang tergabung dalam promo ini.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection
