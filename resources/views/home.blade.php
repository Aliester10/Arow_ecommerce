@extends('layouts.app')

@section('content')
<style>
@media (min-width: 768px) {
    .home-row-layout { --sidebar-width: 30%; --mega-height: 30rem; }
    .home-row-layout .home-sidebar { flex: 0 0 var(--sidebar-width); max-width: var(--sidebar-width); }
    .home-row-layout .home-banner { flex: 1 1 0; min-width: 0; }
    .home-row-layout .home-banner-inner { height: var(--mega-height) !important; }
    .home-row-layout .sidebar-container { height: var(--mega-height) !important; }
}

/* Integrated Solutions Section Styles */
.integrated-solutions-section {
    transition: all 0.3s ease;
}

.integrated-solutions-section .category-card {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.integrated-solutions-section .category-card:hover {
    transform: translateY(-4px);
}

.integrated-solutions-section .cta-button {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.integrated-solutions-section .cta-button:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.integrated-solutions-section .subcategory-item {
    transition: color 0.2s ease;
}

.integrated-solutions-section .subcategory-item:hover {
    color: #ea580c;
    transform: translateX(4px);
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .integrated-solutions-section .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-width: 768px) {
    .integrated-solutions-section .grid-cols-1 {
        grid-template-columns: 1fr;
    }
    
    .integrated-solutions-section .text-center {
        text-align: center;
    }
    
    .integrated-solutions-section .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
}
</style>
<div class="container mx-auto px-2 sm:px-4">

    <!-- ================= ROW 1 : SIDEBAR + BANNER ================= -->
    <div class="home-row-layout flex flex-col md:flex-row gap-4 md:gap-6 mb-8 md:mb-10 relative" style="--sidebar-width: 30%; --sidebar-gap: 1.5rem; --mega-height: 30rem;">

        <!-- Sidebar Categories -->
        <aside class="home-sidebar w-full hidden md:block z-40">
            @include('partials.sidebar')
        </aside>

        <!-- Banner -->
        <div class="home-banner w-full relative z-0">
            <div class="home-banner-inner relative bg-gray-200 rounded-lg md:rounded-xl overflow-hidden shadow-sm h-40 sm:h-64 md:h-96 group">

                <!-- Slider Container -->
                <div id="bannerSlider" class="h-full flex transition-transform duration-500 ease-in-out">
                    
                    @forelse($mainBanners as $banner)
                        <div class="w-full h-full flex-shrink-0 relative">
                            @if(Str::startsWith($banner->gambar_slider_banner, 'http'))
                                <img src="{{ $banner->gambar_slider_banner }}" 
                                    alt="{{ $banner->title ?? 'Banner' }}"
                                    class="w-full h-full object-cover">

                            @elseif(file_exists(public_path('storage/images/' . $banner->gambar_slider_banner)))
                                <img src="{{ asset('storage/images/' . $banner->gambar_slider_banner) }}" 
                                    alt="{{ $banner->title ?? 'Banner' }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-400">
                                    <div class="text-center px-4">
                                        <i class="fas fa-image text-4xl sm:text-6xl mb-2 sm:mb-4"></i>
                                        <p class="font-bold text-sm sm:text-xl">{{ __('messages.banner_image') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-400">
                            <div class="text-center px-4">
                                <i class="fas fa-images text-4xl sm:text-6xl mb-2 sm:mb-4"></i>
                                <p class="font-bold text-sm sm:text-xl">{{ __('messages.no_banners_available') }}</p>
                            </div>
                        </div>
                    @endforelse

                </div>

                <!-- Controls -->
                @if($mainBanners->count() > 1)
                <button id="prevBtn"
                        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-1 sm:p-2 rounded-full shadow-md transition text-xs sm:text-base">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button id="nextBtn"
                        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-1 sm:p-2 rounded-full shadow-md transition text-xs sm:text-base">
                    <i class="fas fa-chevron-right"></i>
                </button>
                @endif

            </div>
        </div>

    </div>
    <!-- ================= END ROW 1 ================= -->


    <!-- ================= ROW 2.5 : INTEGRATED SOLUTIONS ================= -->
    @if($integratedSolution && $integratedCategories->count() > 0)
    <div class="integrated-solutions-section mb-8 md:mb-12 relative overflow-hidden rounded-xl" 
         style="@if($integratedSolution->background_image) 
                    background-image: url('{{ asset('storage/images/' . $integratedSolution->background_image) }}'); 
                    background-size: cover; 
                    background-position: center;
                    background-repeat: no-repeat;
                 @else 
                    background: linear-gradient(135deg, #FFB347 0%, #FF6B35 50%, #FF5F57 100%);
                 @endif">
        
        <!-- Overlay for better text visibility -->
        <div class="absolute inset-0 bg-black/10"></div>
        
        <div class="relative z-10 container mx-auto px-2 sm:px-4 py-8 md:py-12">
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-center">
                
                <!-- Left Column: Title and Button -->
                <div class="w-full lg:w-1/3 text-center lg:text-left">
                    <!-- Orange horizontal line above title -->
                    <div class="h-2 bg-orange-500 mb-4 mx-auto lg:mx-0" style="height: 6px;"></div>
                    
                    <!-- Main Title -->
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                        Integrated Solutions for Modern Businesses
                    </h2>
                    
                    <!-- Orange horizontal line below title -->
                    <div class="h-2 bg-orange-500 mb-6 mx-auto lg:mx-0" style="height: 6px;"></div>
                    
                    <!-- CTA Button -->
                    <button class="px-8 py-3 text-white font-semibold rounded-full transition-all duration-300 hover:opacity-90 hover:shadow-lg"
                            style="background-color: #FF5F57;">
                        See Now
                    </button>
                </div>
                
                <!-- Right Column: Category Cards (Horizontal Layout) -->
                <div class="w-full lg:w-2/3">
                    <div class="flex flex-col md:flex-row gap-4 md:gap-6 justify-center items-stretch">
                        @foreach($integratedCategories as $categoryData)
                            @if($categoryData['category'])
                            <div class="flex-1 max-w-sm">
                                <!-- Category Image with White Background -->
                                <div class="bg-white rounded-lg shadow-lg p-3 mb-3">
                                    <div class="aspect-[4/3] overflow-hidden rounded">
                                        @if($categoryData['image'] && file_exists(public_path('storage/images/' . $categoryData['image'])))
                                            <img src="{{ asset('storage/images/' . $categoryData['image']) }}" 
                                                 alt="{{ $categoryData['category']->nama_kategori }}"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                                <i class="fas fa-folder text-orange-500 text-4xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Category Name (No Background) -->
                                <h3 class="font-bold text-lg text-gray-800 mb-3 text-center">
                                    {{ $categoryData['category']->nama_kategori }}
                                </h3>
                                
                                <!-- Subcategories List (No Background) -->
                                @if($categoryData['subcategories']->count() > 0)
                                    <div class="grid grid-cols-2 gap-y-2 gap-x-4 px-2">
                                        @foreach($categoryData['subcategories'] as $subcategory)
                                            <div class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-orange-600 transition-colors">
                                                <i class="fas fa-chevron-right text-xs mr-2 text-orange-500 flex-shrink-0"></i>
                                                <span class="truncate">{{ $subcategory->nama_subkategori }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic text-center">No subcategories available</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @endif
    <!-- ================= END ROW 2.5 ================= -->


    <!-- ================= ROW 2.6 : NEW ARRIVAL PRODUCTS ================= -->
    <div class="mb-8 md:mb-12">

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-star text-orange-500 text-lg sm:text-xl"></i>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                    {{ __('messages.new_arrival_products') }}
                </h2>
            </div>

            <a href="{{ route('products.index') }}" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                {{ __('messages.view_all') }}
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-4">
            @forelse($products as $product)
                <div class="flex flex-col h-full bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden shadow-md group hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-skeleton-container>
                    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full">
                        <!-- Product Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-white shrink-0">
                            <!-- Skeleton Loading -->
                            <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0" style="z-index: 30;"></div>

                            <!-- Product Image (z-10) -->
                            @php
                                $imagePath = null;
                                if ($product->gambar_produk) {
                                    $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                    $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                    $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                    
                                    if (file_exists(public_path($path1))) $imagePath = $path1;
                                    elseif (file_exists(public_path($path2))) $imagePath = $path2;
                                    elseif (file_exists(public_path($path3))) $imagePath = $path3;
                                }
                            @endphp

                            @if($imagePath)
                                <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                    <img src="{{ asset($imagePath) }}" 
                                         alt="{{ $product->nama_produk }}" 
                                         class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-110"
                                         loading="lazy">
                                </div>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                    <i class="fas fa-image text-gray-300 text-2xl sm:text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex flex-col flex-grow p-2 sm:p-3 bg-white">
                            <!-- Product Name -->
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-800 mb-1 sm:mb-2 line-clamp-2 leading-tight">
                                {{ $product->nama_produk }}
                            </h3>

                            <!-- Price Section -->
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    @if($product->harga_diskon && $product->harga_diskon < $product->harga_produk)
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <span class="text-xs sm:text-sm font-bold text-red-600">
                                                Rp. {{ number_format($product->harga_diskon, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-gray-400 line-through">
                                                {{ number_format($product->harga_produk, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs sm:text-sm font-bold text-gray-800">
                                            Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Cart Button -->
                                <button onclick="addToCart({{ $product->id_produk }}, 1)" 
                                        class="bg-orange-500 hover:bg-orange-600 text-white p-1.5 sm:p-2 rounded-lg transition-colors">
                                    <i class="fas fa-shopping-cart text-xs sm:text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-2 sm:col-span-3 lg:col-span-6 w-full text-center py-8 sm:py-12 bg-white rounded-lg sm:rounded-xl border border-dashed border-gray-300">
                    <i class="fas fa-box-open text-gray-300 text-4xl sm:text-5xl mb-2 sm:mb-4"></i>
                    <p class="text-gray-500 font-medium text-sm sm:text-base">Belum ada produk baru.</p>
                </div>
            @endforelse

        </div>

    </div>
    <!-- ================= END ROW 2.6 ================= -->

    <!-- ================= ROW 2.7 : SPECIAL DEALS ================= -->
    @if($specialDeal && $specialDealProducts->count() > 0)
    <div class="mb-8 md:mb-12 relative overflow-hidden rounded-2xl p-8 lg:p-12"
         style="background: linear-gradient(to right, #FF8C00, #FFA500, #FFD700);">
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center lg:items-stretch gap-8 lg:gap-12">
            
            <!-- Left Column: Title and Button -->
            <div class="w-full lg:w-2/5 text-center lg:text-left flex flex-col justify-center items-center lg:items-start">
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-2 leading-tight drop-shadow-lg">
                    Special Deals
                </h2>
                @if($specialDeal->subtitle)
                <p class="text-xl sm:text-2xl lg:text-3xl text-white mb-8 font-medium drop-shadow">
                    {{ $specialDeal->subtitle }}
                </p>
                @endif
                
                <!-- CTA Button -->
                <a href="{{ route('special-deals.public.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 font-bold rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:bg-orange-50 group">
                    <span class="mr-2">See All</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
            
            <!-- Right Column: Product Cards -->
            <div class="w-full lg:w-3/5 flex justify-center lg:justify-end items-center">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($specialDealProducts->take(3) as $product)
                        <div class="group">
                            <!-- Product Card with White Background and Enhanced Styling -->
                            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                                <!-- Product Image Container -->
                                <div class="relative aspect-square overflow-hidden bg-gray-50">
                                    @php
                                        $imagePath = null;
                                        if ($product->gambar_produk) {
                                            $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                            $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                            $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                            
                                            if (file_exists(public_path($path1))) $imagePath = $path1;
                                            elseif (file_exists(public_path($path2))) $imagePath = $path2;
                                            elseif (file_exists(public_path($path3))) $imagePath = $path3;
                                        }
                                    @endphp
                                    
                                    @if($imagePath)
                                        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                                            <img src="{{ asset($imagePath) }}" 
                                                 alt="{{ $product->nama_produk }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </a>
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Discount Badge -->
                                    @if($product->special_deal_discount)
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-2 rounded-full text-sm font-bold shadow-lg z-10">
                                        {{ $product->special_deal_discount }}%
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-4 lg:p-5">
                                    <!-- Product Name -->
                                    <h3 class="font-bold text-lg lg:text-xl text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                        {{ $product->nama_produk }}
                                    </h3>
                                    
                                    <!-- Price Section -->
                                    <div class="space-y-2">
                                        @if($product->special_deal_price)
                                            <div class="flex items-center gap-3">
                                                <span class="text-xl lg:text-2xl font-bold text-red-600">
                                                    Rp. {{ number_format($product->special_deal_price, 0, ',', '.') }}
                                                </span>
                                                <span class="text-sm lg:text-base text-gray-400 line-through">
                                                    Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xl lg:text-2xl font-bold text-gray-800">
                                                Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Add to Cart Button -->
                                    <button onclick="addToCart({{ $product->id_produk }}, 1)" 
                                            class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center justify-center gap-2">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    @endif
    <!-- ================= END ROW 2.7 ================= -->

    <!-- ================= ROW 2.8 : OUR IN HOUSE BRAND ================= -->
    @if($inHouseBrandsWithProducts && count($inHouseBrandsWithProducts) > 0)
    <div class="mb-8 md:mb-12">
        
        <!-- Section Header with Horizontal Lines -->
        <div class="flex items-center justify-center mb-8 md:mb-12 relative">
            <!-- Decorative gradient background -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-50 to-purple-50 opacity-50"></div>
            
            <div class="flex items-center justify-center relative z-10 w-full">
                <div class="flex-1 h-0.5 bg-gradient-to-r from-transparent via-gray-300 to-gray-400"></div>
                <h2 class="px-6 sm:px-8 text-xl sm:text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 whitespace-nowrap drop-shadow-lg">
                    Our In House Brand
                </h2>
                <div class="flex-1 h-0.5 bg-gradient-to-l from-transparent via-gray-300 to-gray-400"></div>
            </div>
        </div>

        <!-- Brand Cards Container - Side by Side -->
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            @foreach($inHouseBrandsWithProducts as $index => $brandData)
                @php
                    $brand = $brandData['brand'];
                    $products = $brandData['products'];
                    $bgColor = $index === 0 ? '#9FCEDB' : '#93AB95';
                    $brandName = strtolower($brand->nama_brand);
                    $isEducation = strpos($brandName, 'education') !== false;
                @endphp
                
                <div class="flex-1 relative shadow-xl p-6 md:p-8 transform transition-all duration-500 hover:scale-105 hover:shadow-2xl group"
                     style="background-color: {{ $bgColor }}; border-radius: 50px !important; overflow: hidden;">
                    
                    <!-- Background Image Overlay -->
                    @if($brand->gambar_background)
                        <div class="absolute inset-0">
                            @if(file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                <img src="{{ asset('storage/images/' . $brand->gambar_background) }}" 
                                     alt="{{ $brand->nama_brand }} Background"
                                     class="w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-20"
                                     style="opacity: 0.11;">
                            @endif
                        </div>
                    @endif
                    
                    <!-- Decorative overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
                    
                    <!-- Content Container -->
                    <div class="relative z-10">
                        <!-- Brand Logo and Description -->
                        <div class="text-center mb-6">
                            <!-- Logo -->
                            @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" 
                                     alt="{{ $brand->nama_brand }} Logo"
                                     class="h-12 md:h-16 mx-auto mb-4 object-contain">
                            @else
                                <div class="text-white font-bold text-xl md:text-2xl mb-4">
                                    PT. ARO BASKARA ESA
                                </div>
                            @endif
                            
                            <!-- Description -->
                            <p class="text-white text-sm md:text-base mb-6">
                                Our trusted in-house brand, built for quality and performance
                            </p>
                            
                            <!-- See All Button -->
                            <a href="{{ route('products.index', ['brand' => $brand->id_brand]) }}" 
                               class="inline-flex items-center justify-center px-8 py-3 bg-white/90 backdrop-blur-sm text-gray-800 font-semibold rounded-full transition-all duration-300 hover:scale-110 hover:shadow-xl hover:bg-white group mb-6">
                                <span class="group-hover:text-blue-600 transition-colors duration-300">See All</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                        
                        <!-- Products Grid -->
                        @if($products->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @foreach($products as $product)
                                    <div class="bg-white overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                                         style="border-radius: 10px;">
                                        <!-- Product Image -->
                                        <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                                            @php
                                                $imagePath = null;
                                                if ($product->gambar_produk) {
                                                    $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                                    $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                                    $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                                    
                                                    if (file_exists(public_path($path1))) $imagePath = $path1;
                                                    elseif (file_exists(public_path($path2))) $imagePath = $path2;
                                                    elseif (file_exists(public_path($path3))) $imagePath = $path3;
                                                }
                                            @endphp
                                            
                                            @if($imagePath)
                                                <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                                                    <img src="{{ asset($imagePath) }}" 
                                                         alt="{{ $product->nama_produk }}"
                                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                                </a>
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="p-3">
                                            <!-- Product Name -->
                                            <h3 class="font-semibold text-sm text-gray-800 mb-2 line-clamp-2">
                                                {{ $product->nama_produk }}
                                            </h3>
                                            
                                            <!-- Rating Section -->
                                            <div class="flex items-center gap-1 mb-2">
                                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                <span class="text-gray-600 text-xs">
                                                    {{ $product->ulasan && $product->ulasan->count() > 0 
                                                        ? number_format($product->ulasan->avg('rating_ulasan'), 1) 
                                                        : '0.0' }}
                                                </span>
                                                <span class="text-gray-400 text-xs">|</span>
                                                <span class="text-gray-400 text-xs">
                                                    {{ $isEducation ? $product->ulasan->count() . ' sold' : $product->ulasan->count() . ' terjual' }}
                                                </span>
                                            </div>
                                            
                                            <!-- Separator Line -->
                                            <div class="border-t border-gray-200 mb-2"></div>
                                            
                                            <!-- Price (Right Aligned) -->
                                            <div class="text-right">
                                                <span class="text-sm font-bold text-gray-800">
                                                    Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-white text-sm">
                                    No products available for this brand yet.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- ================= END ROW 2.8 ================= -->

    <!-- ================= ROW 2.9 : TOP BRAND ================= -->
    @if($topBrands && $topBrands->count() > 0)
    <div class="mb-8 md:mb-12">
        
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl"></i>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                        Top Brand
                    </h2>
                    <p class="text-sm text-gray-600">
                        Best quality guaranteed.
                    </p>
                </div>
            </div>

            <a href="{{ route('products.index', ['brand' => $selectedTopBrand ? $selectedTopBrand->id_brand : '']) }}" 
               id="viewAllTopBrand" 
               class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                View All
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Brand Menu (Horizontal) -->
        <div class="flex flex-wrap gap-2 mb-6 md:mb-8">
            @foreach($topBrands as $brand)
                <button onclick="loadTopBrandProducts({{ $brand->id_brand }})" 
                        class="brand-tab flex items-center gap-2 px-4 py-2 rounded-full border-2 transition-all duration-300 text-sm font-medium
                               @if($selectedTopBrand && $selectedTopBrand->id_brand == $brand->id_brand)
                                   bg-orange-500 text-white border-orange-500
                               @else
                                   bg-white text-gray-700 border-gray-300 hover:border-orange-500 hover:text-orange-500
                               @endif"
                        data-brand-id="{{ $brand->id_brand }}">
                    @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                        <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" 
                             alt="{{ $brand->nama_brand }}" 
                             class="w-8 h-8 object-contain">
                    @else
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-tag text-gray-500 text-sm"></i>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Products Display -->
        <div id="topBrandProducts" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($topBrandProducts as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <!-- Product Image -->
                        <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                            @php
                                $imagePath = null;
                                if ($product->gambar_produk) {
                                    $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                    $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                    $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                    
                                    if (file_exists(public_path($path1))) $imagePath = $path1;
                                    elseif (file_exists(public_path($path2))) $imagePath = $path2;
                                    elseif (file_exists(public_path($path3))) $imagePath = $path3;
                                }
                            @endphp
                            
                            @if($imagePath)
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $product->nama_produk }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-3 sm:p-4">
                            <!-- Brand Name -->
                            <p class="text-xs text-gray-500 mb-1">
                                ARO BASKARA ESA
                            </p>
                            
                            <!-- Product Name -->
                            <h3 class="font-bold text-sm sm:text-base text-gray-800 mb-2 line-clamp-2">
                                {{ $product->nama_produk }}
                            </h3>
                            
                            <!-- Rating Section -->
                            <div class="flex items-center gap-1 mb-2">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-gray-600 text-xs">
                                    {{ $product->ulasan && $product->ulasan->count() > 0 
                                        ? number_format($product->ulasan->avg('rating_ulasan'), 1) 
                                        : '0.0' }}
                                </span>
                            </div>
                            
                            <!-- Separator Line -->
                            <div class="border-t border-gray-200 mb-2"></div>
                            
                            <!-- Sold Count -->
                            <p class="text-xs text-gray-500 mb-2">
                                {{ $product->ulasan->count() }} terjual
                            </p>
                            
                            <!-- Price -->
                            <p class="text-sm sm:text-base font-bold text-orange-500">
                                Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-2 sm:col-span-3 lg:col-span-4 text-center py-8">
                    <i class="fas fa-box-open text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">No products available for this brand yet.</p>
                </div>
            @endforelse
        </div>
    </div>
    @endif
    <!-- ================= END ROW 2.9 ================= -->


    </div>

<!-- ================= SLIDER SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const slider = document.getElementById('bannerSlider');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let index = 0;
    const total = {{ $mainBanners->count() }};

    if (total > 1) {

        function updateSlider() {
            slider.style.transform = `translateX(-${index * 100}%)`;
        }

        nextBtn.addEventListener('click', () => {
            index = (index + 1) % total;
            updateSlider();
        });

        prevBtn.addEventListener('click', () => {
            index = (index - 1 + total) % total;
            updateSlider();
        });

        setInterval(() => {
            index = (index + 1) % total;
            updateSlider();
        }, 5000);
    }

});

// ================= TOP BRAND AJAX =================
function loadTopBrandProducts(brandId) {
    // Update active tab styling
    document.querySelectorAll('.brand-tab').forEach(tab => {
        if (tab.dataset.brandId == brandId) {
            tab.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
            tab.classList.add('bg-orange-500', 'text-white', 'border-orange-500');
        } else {
            tab.classList.remove('bg-orange-500', 'text-white', 'border-orange-500');
            tab.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        }
    });

    // Update View All link
    const viewAllLink = document.getElementById('viewAllTopBrand');
    if (viewAllLink) {
        viewAllLink.href = `/products?brand=${brandId}`;
    }

    // Fetch products via AJAX
    fetch(`/home/top-brand-products/${brandId}`)
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById('topBrandProducts');
            
            if (data.products && data.products.length > 0) {
                let productsHtml = '';
                
                data.products.forEach(product => {
                    // Handle image path (similar to the blade template logic)
                    let imageHtml = '';
                    if (product.gambar_produk) {
                        imageHtml = `<img src="/storage/images/produk/${product.gambar_produk}" 
                                     alt="${product.nama_produk}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">`;
                    } else {
                        imageHtml = `<div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                     <i class="fas fa-image text-gray-400 text-2xl"></i>
                                   </div>`;
                    }

                    // Calculate rating
                    const rating = product.ulasan && product.ulasan.length > 0 
                        ? (product.ulasan.reduce((sum, review) => sum + review.rating_ulasan, 0) / product.ulasan.length).toFixed(1)
                        : '0.0';
                    
                    const soldCount = product.ulasan ? product.ulasan.length : 0;
                    
                    productsHtml += `
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group">
                            <a href="/products/${product.slug}" class="block">
                                <!-- Product Image -->
                                <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                                    ${imageHtml}
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-3 sm:p-4">
                                    <!-- Brand Name -->
                                    <p class="text-xs text-gray-500 mb-1">
                                        ${data.brand ? data.brand.nama_brand : 'ARO BASKARA ESA'}
                                    </p>
                                    
                                    <!-- Product Name -->
                                    <h3 class="font-bold text-sm sm:text-base text-gray-800 mb-2 line-clamp-2">
                                        ${product.nama_produk}
                                    </h3>
                                    
                                    <!-- Rating Section -->
                                    <div class="flex items-center gap-1 mb-2">
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                        <span class="text-gray-600 text-xs">
                                            ${rating}
                                        </span>
                                    </div>
                                    
                                    <!-- Separator Line -->
                                    <div class="border-t border-gray-200 mb-2"></div>
                                    
                                    <!-- Sold Count -->
                                    <p class="text-xs text-gray-500 mb-2">
                                        ${soldCount} terjual
                                    </p>
                                    
                                    <!-- Price -->
                                    <p class="text-sm sm:text-base font-bold text-orange-500">
                                        Rp ${parseInt(product.harga_produk).toLocaleString('id-ID')}
                                    </p>
                                </div>
                            </a>
                        </div>
                    `;
                });
                
                productsContainer.innerHTML = productsHtml;
            } else {
                productsContainer.innerHTML = `
                    <div class="col-span-2 sm:col-span-3 lg:col-span-4 text-center py-8">
                        <i class="fas fa-box-open text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No products available for this brand yet.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading top brand products:', error);
        });
}
</script>
@endsection
