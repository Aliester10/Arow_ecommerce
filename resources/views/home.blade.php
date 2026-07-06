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

/* Custom animations for modern promo banners */
@keyframes fadeInBanner {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeInBanner 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
<div class="container mx-auto px-2 sm:px-4">
    <!-- Alpine wrapper context for mobile category drawer -->
    <div x-data="{ mobileCategoriesOpen: false, touchStartX: 0, touchStartY: 0 }"
         x-init="$watch('mobileCategoriesOpen', value => {
             if (value) {
                 document.body.style.overflow = 'hidden';
             } else {
                 document.body.style.overflow = '';
             }
         })"
         @keydown.escape.window="mobileCategoriesOpen = false">

        <!-- Mobile Category Trigger Button (hidden on desktop/tablet > 768px) -->
        <div class="block md:hidden mb-4 mt-2">
            <button @click="mobileCategoriesOpen = true"
                    class="w-full flex items-center justify-between px-4 py-3 bg-[#F7931E] hover:bg-[#e07f12] text-white font-semibold rounded-xl shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    aria-label="Kategori Produk"
                    type="button">
                <span class="flex items-center gap-2">
                    <i class="fas fa-bars"></i>
                    <span>Kategori Produk</span>
                </span>
                <i class="fas fa-chevron-right text-sm opacity-80"></i>
            </button>
        </div>

        <!-- Mobile Slide Drawer -->
        <div x-show="mobileCategoriesOpen" 
             class="fixed inset-0 z-50 overflow-hidden md:hidden" 
             style="display: none;" 
             role="dialog" 
             aria-modal="true"
             aria-label="Menu Kategori Produk">
            
            <!-- Overlay -->
            <div x-show="mobileCategoriesOpen"
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-50"
                 x-transition:leave="transition-opacity ease-in duration-300"
                 x-transition:leave-start="opacity-50"
                 x-transition:leave-end="opacity-0"
                 @click="mobileCategoriesOpen = false"
                 class="fixed inset-0 bg-black transition-opacity">
            </div>

            <!-- Drawer Content -->
            <div x-show="mobileCategoriesOpen"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 max-w-[80%] w-full bg-white shadow-2xl flex flex-col z-50 rounded-r-2xl overflow-hidden"
                 @touchstart="touchStartX = $event.touches[0].clientX; touchStartY = $event.touches[0].clientY;"
                 @touchend="
                     let diffX = touchStartX - $event.changedTouches[0].clientX;
                     let diffY = Math.abs(touchStartY - $event.changedTouches[0].clientY);
                     if (diffX > 50 && diffY < 40) mobileCategoriesOpen = false;
                 "
            >
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-4 border-b border-gray-100 text-white" style="background-color:#F7931E">
                    <div class="flex items-center font-semibold text-sm sm:text-base gap-2">
                        <i class="fas fa-list"></i>
                        <span>Kategori Produk</span>
                    </div>
                    <button @click="mobileCategoriesOpen = false" 
                            class="text-white hover:text-orange-100 transition focus:outline-none p-1 rounded-md"
                            aria-label="Tutup Kategori Produk"
                            type="button">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- List Kategori -->
                <div class="flex-1 overflow-y-auto py-2">
                    <ul class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <li x-data="{ open: false }" class="border-b border-gray-50 last:border-0">
                                @php
                                    $iconPath = $category->icon_kategori;
                                    $isSvg = $iconPath ? (strtolower(pathinfo($iconPath, PATHINFO_EXTENSION)) === 'svg') : false;

                                    $iconCandidates = $iconPath ? [
                                        $iconPath,
                                        'storage/' . ltrim($iconPath, '/'),
                                        'storage/images/' . ltrim($iconPath, '/'),
                                    ] : [];

                                    $resolvedIconPath = null;
                                    $resolvedIconFullPath = null;

                                    foreach ($iconCandidates as $candidate) {
                                        $full = public_path($candidate);
                                        if (file_exists($full)) {
                                            $resolvedIconPath = $candidate;
                                            $resolvedIconFullPath = $full;
                                            break;
                                        }
                                    }

                                    $iconExists = (bool) $resolvedIconFullPath;
                                @endphp

                                @if($category->subkategori->count() > 0)
                                    <!-- Expandable Category Button -->
                                    <button @click="open = !open" 
                                            type="button"
                                            class="flex items-center justify-between w-full min-h-[48px] px-4 py-3 text-left hover:bg-orange-50/50 transition duration-150 focus:outline-none"
                                            :aria-expanded="open ? 'true' : 'false'">
                                        <span class="flex items-center gap-3 text-sm text-gray-700 hover:text-orange-600 font-medium truncate flex-1">
                                            @if($iconExists && $isSvg)
                                                @php
                                                    $svg = file_get_contents($resolvedIconFullPath);
                                                    $svg = preg_replace('/<svg(\\s+)/i', '<svg$1style="width:20px;height:20px;" fill="currentColor" stroke="currentColor" ', $svg, 1);
                                                    $svg = preg_replace('/\sfill="(?!none)[^"]*"/i', ' fill="currentColor"', $svg);
                                                    $svg = preg_replace('/\sstroke="(?!none)[^"]*"/i', ' stroke="currentColor"', $svg);
                                                @endphp
                                                <span class="flex-shrink-0 text-orange-500" aria-hidden="true">{!! $svg !!}</span>
                                            @elseif($iconExists)
                                                <img src="{{ asset($resolvedIconPath) }}" alt="{{ $category->nama_kategori }}" class="w-5 h-5 object-contain flex-shrink-0">
                                            @else
                                                <span class="w-5 h-5 flex items-center justify-center flex-shrink-0 text-orange-500">
                                                    <i class="fas fa-tag"></i>
                                                </span>
                                            @endif
                                            <span class="truncate">{{ $category->nama_kategori }}</span>
                                        </span>
                                        <i class="fas fa-chevron-right text-xs text-gray-400 transition-transform duration-200" :class="{ 'rotate-90': open }"></i>
                                    </button>
                                @else
                                    <!-- Direct Category Link -->
                                    <a href="{{ route('products.index', ['category' => $category->nama_kategori]) }}" 
                                       class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:text-orange-600 font-medium w-full min-h-[48px] hover:bg-orange-50/50 transition duration-150">
                                        @if($iconExists && $isSvg)
                                            @php
                                                $svg = file_get_contents($resolvedIconFullPath);
                                                $svg = preg_replace('/<svg(\\s+)/i', '<svg$1style="width:20px;height:20px;" fill="currentColor" stroke="currentColor" ', $svg, 1);
                                                $svg = preg_replace('/\sfill="(?!none)[^"]*"/i', ' fill="currentColor"', $svg);
                                                $svg = preg_replace('/\sstroke="(?!none)[^"]*"/i', ' stroke="currentColor"', $svg);
                                            @endphp
                                            <span class="flex-shrink-0 text-orange-500" aria-hidden="true">{!! $svg !!}</span>
                                        @elseif($iconExists)
                                            <img src="{{ asset($resolvedIconPath) }}" alt="{{ $category->nama_kategori }}" class="w-5 h-5 object-contain flex-shrink-0">
                                        @else
                                            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0 text-orange-500">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                        @endif
                                        <span class="truncate flex-1">{{ $category->nama_kategori }}</span>
                                    </a>
                                @endif

                                <!-- Subcategories Accordion -->
                                @if($category->subkategori->count() > 0)
                                    <div x-show="open" 
                                         x-transition:enter="transition-all ease-out duration-200"
                                         x-transition:enter-start="max-h-0 opacity-0 overflow-hidden"
                                         x-transition:enter-end="max-h-[1000px] opacity-100 overflow-hidden"
                                         x-transition:leave="transition-all ease-in duration-200"
                                         x-transition:leave-start="max-h-[1000px] opacity-100 overflow-hidden"
                                         x-transition:leave-end="max-h-0 opacity-0 overflow-hidden"
                                         class="bg-gray-50 border-t border-gray-100 pl-6 pr-4 py-1"
                                         style="display: none;">
                                        
                                        <ul class="divide-y divide-gray-100/50">
                                            <!-- Link to View All Products of this Category -->
                                            <li>
                                                <a href="{{ route('products.index', ['category' => $category->nama_kategori]) }}" 
                                                   class="block py-2 text-xs text-orange-600 hover:text-orange-700 font-semibold min-h-[44px] flex items-center">
                                                    Semua {{ $category->nama_kategori }}
                                                </a>
                                            </li>
                                            
                                            @foreach($category->subkategori as $sub)
                                                <li x-data="{ openSub: false }">
                                                    @if($sub->subSubkategori->count() > 0)
                                                        <!-- Expandable Subcategory Button -->
                                                        <button @click="openSub = !openSub" 
                                                                type="button"
                                                                class="flex items-center justify-between w-full min-h-[44px] py-2 text-left text-xs text-gray-600 hover:text-orange-600 font-medium focus:outline-none"
                                                                :aria-expanded="openSub ? 'true' : 'false'">
                                                            <span class="truncate flex-1">{{ $sub->nama_subkategori }}</span>
                                                            <i class="fas fa-chevron-right text-[10px] text-gray-400 transition-transform duration-200" :class="{ 'rotate-90': openSub }"></i>
                                                        </button>
                                                    @else
                                                        <!-- Direct Subcategory Link -->
                                                        <a href="{{ route('products.index', ['category' => $sub->nama_subkategori]) }}" 
                                                           class="block py-2 text-xs text-gray-600 hover:text-orange-600 font-medium truncate min-h-[44px] flex items-center">
                                                            {{ $sub->nama_subkategori }}
                                                        </a>
                                                    @endif
                                                    
                                                    <!-- Sub-subcategories Accordion -->
                                                    @if($sub->subSubkategori->count() > 0)
                                                        <div x-show="openSub" 
                                                             x-transition:enter="transition-all ease-out duration-200"
                                                             x-transition:enter-start="max-h-0 opacity-0 overflow-hidden"
                                                             x-transition:enter-end="max-h-[500px] opacity-100 overflow-hidden"
                                                             x-transition:leave="transition-all ease-in duration-200"
                                                             x-transition:leave-start="max-h-[500px] opacity-100 overflow-hidden"
                                                             x-transition:leave-end="max-h-0 opacity-0 overflow-hidden"
                                                             class="bg-gray-100/50 pl-4 py-1 rounded-lg mb-2"
                                                             style="display: none;">
                                                            <ul>
                                                                <!-- Link to View All Products of this Subcategory -->
                                                                <li>
                                                                    <a href="{{ route('products.index', ['category' => $sub->nama_subkategori]) }}" 
                                                                       class="block py-2 text-[11px] text-orange-600 hover:text-orange-700 font-semibold min-h-[40px] flex items-center">
                                                                        Semua {{ $sub->nama_subkategori }}
                                                                    </a>
                                                                </li>
                                                                
                                                                @foreach($sub->subSubkategori as $subSub)
                                                                    <li>
                                                                        <a href="{{ route('products.index', ['category' => $subSub->nama_sub_subkategori]) }}" 
                                                                           class="block py-2 text-[11px] text-gray-500 hover:text-orange-600 truncate min-h-[40px] flex items-center">
                                                                            {{ $subSub->nama_sub_subkategori }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @empty
                            <li class="px-4 py-6 text-center text-sm text-gray-500">
                                <i class="fas fa-inbox text-gray-300 text-xl mb-2 block"></i>
                                Tidak ada kategori
                            </li>
                        @endforelse
                </ul>
            </div>
        </div>
    </div>

        <!-- ================= ROW 1 : SIDEBAR + BANNER ================= -->
        <div class="home-row-layout flex flex-col md:flex-row gap-4 md:gap-6 mb-8 md:mb-10 relative" style="--sidebar-width: 30%; --sidebar-gap: 1.5rem; --mega-height: 30rem;">

        <!-- Sidebar Categories -->
        <aside class="home-sidebar w-full hidden md:block z-20">
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
                
                <!-- Left Column: Title -->
                <div class="w-full lg:w-1/3 text-center lg:text-left">
                    <!-- Orange horizontal line above title -->
                    <div class="h-2 bg-orange-500 mb-4 mx-auto lg:mx-0" style="height: 6px;"></div>
                    
                    <!-- Main Title -->
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                        Integrated Solutions for Modern Businesses
                    </h2>
                    
                    <!-- Orange horizontal line below title -->
                    <div class="h-2 bg-orange-500 mb-6 mx-auto lg:mx-0" style="height: 6px;"></div>
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
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @endif    <!-- ================= END ROW 2.5 ================= -->


    <!-- ================= ROW 2.6 : NEW ARRIVAL PRODUCTS ================= -->
    <div class="mb-8 md:mb-12">

        <!-- Section Header -->
        <div class="mb-4 md:mb-6 flex justify-between items-center">
            <h2 class="text-xl md:text-2xl font-bold" style="color: #0f172a;">
                Produk Unggulan
            </h2>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @forelse($products as $index => $product)
                <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300" data-skeleton-container>
                    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full relative group">
                        <!-- No top badge per user request -->

                        <!-- Product Image -->
                        <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                            @if(isset($product) && $product->image_url)
                                <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0" style="z-index: 30;"></div>
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->nama_produk }}" 
                                         class="object-contain max-w-full max-h-full"
                                         data-skeleton-image
                                         loading="lazy">
                                </div>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                    <i class="fas fa-image text-gray-300 text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex flex-col flex-grow p-3 bg-white">
                            <!-- Product Name -->
                            <h3 class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                {{ $product->nama_produk }}
                            </h3>

                            <!-- Price Section -->
                            <div class="mt-auto">
                                <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                @if($product->harga_diskon && $product->harga_diskon < $product->harga_produk)
                                    <span class="text-[15px] font-bold text-[#eab308]">
                                        Rp {{ number_format($product->harga_diskon, 0, ',', '.') }},00
                                    </span>
                                @else
                                    <span class="text-[15px] font-bold text-[#eab308]">
                                        Rp {{ number_format($product->harga_produk, 0, ',', '.') }},00
                                    </span>
                                @endif
                            </div>

                            <!-- Seller Info mapping to actual product data -->
                            <div class="mt-3 flex flex-col gap-1">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                    <span class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $product->asal_produk ?: 'Indonesia' }}</span>
                                </div>
                                <div class="text-[11px] text-gray-400">
                                    Tipe: {{ $product->tipe_produk ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-2 sm:col-span-3 lg:col-span-6 w-full text-center py-8 sm:py-12 bg-white border border-dashed border-gray-300">
                    <i class="fas fa-box-open text-gray-300 text-4xl sm:text-5xl mb-2 sm:mb-4"></i>
                    <p class="text-gray-500 font-medium text-sm sm:text-base">Belum ada produk baru.</p>
                </div>
            @endforelse

        </div>

    </div>
    <!-- ================= END ROW 2.6 ================= -->

    <!-- ================= ROW 2.7 : PROMO CAMPAIGN ================= -->
    @if($activePromos && $activePromos->count() > 0)
        <div class="space-y-6 mb-8 md:mb-12">
            @foreach($activePromos as $activePromo)
                @if($activePromo->banner)
                    <div class="animate-fade-in">
                        <a href="{{ route('promo-campaigns.public.show', $activePromo->slug) }}" 
                           class="block overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 ease-in-out group relative">
                            <!-- Background Image with Scale Zoom Effect on Hover -->
                            <img src="{{ asset('storage/images/' . $activePromo->banner) }}" 
                                 alt="{{ $activePromo->title }}" 
                                 class="w-full h-auto object-cover max-h-96 md:max-h-110 lg:max-h-125 min-h-48 transition-transform duration-300 ease-in-out group-hover:scale-[1.03]">
                            
                            <!-- Premium Dark Gradient Overlay (Always Visible) -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-transparent flex flex-col justify-end p-5 sm:p-8 md:p-10 lg:p-12 z-10 text-white">
                                <div class="max-w-2xl text-left">
                                    <!-- Main Title with clear hierarchy -->
                                    <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold mb-1.5 sm:mb-2 tracking-tight leading-tight drop-shadow-md text-white">
                                        {{ $activePromo->title }}
                                    </h3>
                                    
                                    <!-- Subtitle with appropriate max-width and line clamping -->
                                    @if($activePromo->subtitle)
                                        <p class="text-white/90 text-[11px] sm:text-xs md:text-sm lg:text-base font-medium drop-shadow opacity-95 mb-4 sm:mb-5 max-w-xl line-clamp-2">
                                            {{ $activePromo->subtitle }}
                                        </p>
                                    @endif
                                    
                                    <!-- CTA & Info Row -->
                                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                                        <span class="inline-flex items-center justify-center px-4 py-2.5 sm:px-6 sm:py-3 bg-[#F7931E] hover:bg-[#e07f12] text-white text-[10px] sm:text-xs md:text-sm font-bold rounded-xl shadow-md transition-all duration-300 hover:scale-[1.03]">
                                            <span>Kunjungi Halaman Promo</span>
                                            <i class="fas fa-arrow-right ml-1.5 text-[9px] sm:text-[10px] md:text-xs"></i>
                                        </span>
                                        <span class="text-[9px] sm:text-[10px] md:text-xs text-white/80 font-medium bg-black/40 backdrop-blur-sm px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg border border-white/10 flex items-center gap-1.5">
                                            <i class="far fa-clock"></i> Berlaku s.d {{ $activePromo->end_date->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <!-- Fallback Styled HTML Banner if banner image is not uploaded -->
                    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-10 lg:p-14 text-white shadow-xl hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 animate-fade-in"
                         style="background: linear-gradient(135deg, #FF3D00 0%, #FF9100 50%, #FFC400 100%);">
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="text-left">
                                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-2 drop-shadow-md">
                                    {{ $activePromo->title }}
                                </h2>
                                @if($activePromo->subtitle)
                                    <p class="text-lg sm:text-xl lg:text-2xl font-medium drop-shadow opacity-95 mb-4">
                                        {{ $activePromo->subtitle }}
                                    </p>
                                @endif
                                <p class="text-xs sm:text-sm font-medium bg-black/20 inline-block px-3 py-1 rounded-md">
                                    Berlaku s/d {{ $activePromo->end_date->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('promo-campaigns.public.show', $activePromo->slug) }}" 
                                   class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 text-base font-extrabold rounded-full transition-all duration-300 hover:scale-105 hover:bg-orange-50 group shadow-lg">
                                    <span>Kunjungi Halaman Promo</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Decorative background elements -->
                        <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-white/10 blur-xl"></div>
                        <div class="absolute -left-20 -top-20 w-60 h-60 rounded-full bg-white/10 blur-lg"></div>
                    </div>
                @endif
            @endforeach
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
                
                <div class="flex-1 relative shadow-xl p-4 md:p-8 transform transition-all duration-500 hover:scale-[1.02] lg:hover:scale-105 hover:shadow-2xl group"
                     style="background: linear-gradient({{ $brand->rgba_overlay }}, {{ $brand->rgba_overlay }}); border-radius: 30px !important; overflow: hidden;">
                    
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
                        <div class="text-center mb-4 lg:mb-6">
                            <!-- Logo -->
                            @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" 
                                     alt="{{ $brand->nama_brand }} Logo"
                                     class="h-10 md:h-16 mx-auto mb-3 md:mb-4 object-contain">
                            @else
                                <div class="text-white font-bold text-lg md:text-2xl mb-3 md:mb-4">
                                    PT. ARO BASKARA ESA
                                </div>
                            @endif
                            
                            <!-- Description -->
                            <p class="text-white text-xs md:text-base mb-4 md:mb-6">
                                Our trusted in-house brand, built for quality and performance
                            </p>
                            
                            <!-- See All Button -->
                            <a href="{{ route('products.index', ['brand' => $brand->id_brand]) }}" 
                               class="inline-flex items-center justify-center px-6 py-2 md:px-8 md:py-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs md:text-base font-semibold rounded-full transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-white group mb-4 md:mb-6">
                                <span class="group-hover:text-blue-600 transition-colors duration-300">See All</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                        
                        <!-- Products Grid -->
                        @if($products->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4">
                                @foreach($products as $product)
                                    <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300" data-skeleton-container style="border-radius: 8px; overflow: hidden;">
                                        <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full relative group">
                                            <!-- Product Image -->
                                            <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                                                @if(isset($product) && $product->image_url)
                                                    <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0" style="z-index: 30;"></div>
                                                    <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                                        <img src="{{ $product->image_url }}" 
                                                             alt="{{ $product->nama_produk }}" 
                                                             class="w-full h-full object-cover"
                                                             data-skeleton-image
                                                             loading="lazy">
                                                    </div>
                                                @else
                                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                                        <i class="fas fa-image text-gray-300 text-3xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Product Info -->
                                            <div class="flex flex-col flex-grow p-3 bg-white">
                                                <!-- Product Name -->
                                                <h3 class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                                    {{ $product->nama_produk }}
                                                </h3>

                                                <!-- Price Section -->
                                                <div class="mt-auto">
                                                    <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                                    @if($product->harga_diskon && $product->harga_diskon < $product->harga_produk)
                                                        <span class="text-[15px] font-bold text-[#eab308]">
                                                            Rp {{ number_format($product->harga_diskon, 0, ',', '.') }},00
                                                        </span>
                                                    @else
                                                        <span class="text-[15px] font-bold text-[#eab308]">
                                                            Rp {{ number_format($product->harga_produk, 0, ',', '.') }},00
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Seller Info -->
                                                <div class="mt-3 flex flex-col gap-1">
                                                    <div class="flex items-center gap-1">
                                                        <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                                        <span class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $product->asal_produk ?: 'Indonesia' }}</span>
                                                    </div>
                                                    <div class="text-[11px] text-gray-400">
                                                        Tipe: {{ $product->tipe_produk ?: '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 lg:py-8">
                                <p class="text-white text-xs lg:text-sm">
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
                        Produk Unggulan
                    </h2>
                    <p class="text-sm text-gray-600">
                        Kualitas terbaik terjamin.
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

        <!-- Brand Menu (Horizontal Scrollable Premium Cards) -->
        <div class="relative mb-6 md:mb-8">
            <div class="flex gap-4 sm:gap-5 overflow-x-auto py-4 px-2 -mx-2 scrollbar-hide" style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
                @foreach($topBrands as $brand)
                    @php
                        $isActive = $selectedTopBrand && $selectedTopBrand->id_brand == $brand->id_brand;
                        $rgbaColor = $brand->rgba_overlay ?: 'rgba(14, 165, 233, 0.7)';
                        $tintBg = str_replace('0.7', '0.04', $rgbaColor);
                        $softShadow = str_replace('0.7', '0.15', $rgbaColor);
                        $borderColor = $brand->overlay_color ?: '#0EA5E9';
                    @endphp
                    <button onclick="loadTopBrandProducts({{ $brand->id_brand }})" 
                            class="brand-tab flex-shrink-0 group relative flex flex-col items-center justify-between p-4 w-28 h-32 sm:w-32 sm:h-36 rounded-2xl transition-all duration-300 overflow-hidden
                                   @if($isActive)
                                       bg-white shadow-xl scale-105 brand-active ring-2
                                   @else
                                       bg-white ring-1 ring-gray-100 hover:ring-gray-300 hover:shadow-md hover:-translate-y-0.5
                                   @endif"
                            style="@if($isActive)
                                       border-color: {{ $borderColor }};
                                       box-shadow: 0 10px 25px -5px {{ $softShadow }};
                                       background-color: {{ $tintBg }};
                                   @endif"
                            data-brand-id="{{ $brand->id_brand }}"
                            data-overlay-color="{{ $borderColor }}"
                            data-rgba-overlay="{{ $rgbaColor }}"
                            data-banner-image="{{ $brand->banner_image && file_exists(public_path('storage/images/' . $brand->banner_image)) ? asset('storage/images/' . $brand->banner_image) : ($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)) ? asset('storage/images/' . $brand->gambar_background) : '') }}"
                            data-banner-title="{{ $brand->banner_title }}"
                            data-banner-subtitle="{{ $brand->banner_subtitle }}"
                            data-banner-button-text="{{ $brand->banner_button_text }}"
                            data-banner-button-link="{{ $brand->banner_button_link }}"
                            data-show-product-count="{{ $brand->show_product_count }}"
                            data-show-category-count="{{ $brand->show_category_count }}"
                            data-show-official-badge="{{ $brand->show_official_badge }}"
                            data-products-count="{{ $brand->products_count }}"
                            data-categories-count="{{ $brand->categories_count }}"
                            data-brand-name="{{ $brand->nama_brand }}"
                            title="{{ $brand->nama_brand }}">
                        


                        {{-- Logo Brand --}}
                        <div class="flex-1 flex items-center justify-center w-full min-h-0 pt-2 z-10">
                            @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" 
                                     alt="{{ $brand->nama_brand }}" 
                                     class="max-w-full max-h-12 sm:max-h-14 object-contain transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-tag text-gray-400 text-sm"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Text Info --}}
                        <div class="w-full text-center mt-3 pb-0.5 border-t border-gray-50 pt-2.5 shrink-0 z-10">
                            <span class="block text-xs font-bold text-gray-800 truncate leading-tight">{{ $brand->nama_brand }}</span>
                            
                            @if($brand->show_product_count)
                                <span class="block text-[10px] text-gray-500 mt-0.5 font-medium leading-none">{{ $brand->products_count }} Produk</span>
                            @elseif($brand->show_category_count)
                                <span class="block text-[10px] text-gray-500 mt-0.5 font-medium leading-none">{{ $brand->categories_count }} Kategori</span>
                            @else
                                <span class="block text-[10px] text-gray-400 mt-0.5 font-medium leading-none">Lihat Detail</span>
                            @endif
                        </div>

                        {{-- Active Indicator Line --}}
                        <span class="active-indicator absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r rounded-b-2xl transition-all duration-300 {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-x-50' }}"
                              style="background-color: {{ $borderColor }}"></span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Brand Hero Banner (Premium Showcase) -->
        <div id="brandHeroBanner" class="relative overflow-hidden rounded-3xl mb-6 md:mb-8 transition-all duration-500 opacity-100 min-h-[180px] sm:min-h-[220px] md:min-h-[260px] flex flex-col justify-center px-6 py-8 sm:px-12 sm:py-10 text-white shadow-xl"
             style="background-color: {{ $selectedTopBrand ? ($selectedTopBrand->overlay_color ?: '#0EA5E9') : '#0EA5E9' }};">
            
            <!-- Background Image Container -->
            <div id="brandBannerBgContainer" class="absolute inset-0 z-0 pointer-events-none">
                @if($selectedTopBrand && $selectedTopBrand->banner_image && file_exists(public_path('storage/images/' . $selectedTopBrand->banner_image)))
                    <img id="brandBannerBgImg" src="{{ asset('storage/images/' . $selectedTopBrand->banner_image) }}" 
                         alt="Brand Banner Background" 
                         class="w-full h-full object-cover transition-all duration-500">
                @elseif($selectedTopBrand && $selectedTopBrand->gambar_background && file_exists(public_path('storage/images/' . $selectedTopBrand->gambar_background)))
                    <img id="brandBannerBgImg" src="{{ asset('storage/images/' . $selectedTopBrand->gambar_background) }}" 
                         alt="Brand Banner Background" 
                         class="w-full h-full object-cover transition-all duration-500">
                @else
                    <div id="brandBannerBgImgPlaceholder" class="w-full h-full bg-gradient-to-r from-black/10 via-white/5 to-black/10 opacity-30"></div>
                @endif
            </div>

            <!-- Overlay Tint Layer -->
            <div id="brandBannerOverlay" class="absolute inset-0 z-10 transition-colors duration-500"
                 style="background-color: {{ $selectedTopBrand ? ($selectedTopBrand->rgba_overlay ?: 'rgba(14, 165, 233, 0.7)') : 'rgba(14, 165, 233, 0.7)' }};"></div>

            <!-- Content -->
            <div class="relative z-20 max-w-2xl flex flex-col items-start gap-2.5 sm:gap-4 transition-all duration-500 transform translate-y-0" id="brandBannerContent">
                @if($selectedTopBrand && $selectedTopBrand->show_official_badge)
                    <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md px-3.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold uppercase tracking-wider">
                        <i class="fas fa-check-circle text-blue-300"></i> Official Store
                    </span>
                @endif

                <div>
                    <h1 id="brandBannerTitle" class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight drop-shadow-md">
                        {{ $selectedTopBrand ? ($selectedTopBrand->banner_title ?: $selectedTopBrand->nama_brand . ' OFFICIAL') : 'OFFICIAL BRAND' }}
                    </h1>
                    <p id="brandBannerSubtitle" class="text-sm sm:text-base md:text-lg text-white/90 font-light mt-1.5 sm:mt-2 leading-relaxed drop-shadow max-w-xl">
                        {{ $selectedTopBrand ? ($selectedTopBrand->banner_subtitle ?: 'Laptop & Accessories Premium') : 'Laptop & Accessories Premium' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Products Display Grid -->
        <div id="topBrandProducts" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 transition-all duration-300">
            @forelse($topBrandProducts as $product)
                <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300" data-skeleton-container>
                    <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full relative group">
                        <!-- Product Image -->
                        <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                            @if(isset($product) && $product->image_url)
                                <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0" style="z-index: 30;"></div>
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->nama_produk }}" 
                                         class="object-contain max-w-full max-h-full"
                                         data-skeleton-image
                                         loading="lazy">
                                </div>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                    <i class="fas fa-image text-gray-300 text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex flex-col flex-grow p-3 bg-white">
                            <!-- Product Name -->
                            <h3 class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                {{ $product->nama_produk }}
                            </h3>

                            <!-- Price Section -->
                            <div class="mt-auto">
                                <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                @if($product->harga_diskon && $product->harga_diskon < $product->harga_produk)
                                    <span class="text-[15px] font-bold text-[#eab308]">
                                        Rp {{ number_format($product->harga_diskon, 0, ',', '.') }},00
                                    </span>
                                @else
                                    <span class="text-[15px] font-bold text-[#eab308]">
                                        Rp {{ number_format($product->harga_produk, 0, ',', '.') }},00
                                    </span>
                                @endif
                            </div>

                            <!-- Seller Info -->
                            <div class="mt-3 flex flex-col gap-1">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                    <span class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $product->asal_produk ?: 'Indonesia' }}</span>
                                </div>
                                <div class="text-[11px] text-gray-400">
                                    Tipe: {{ $product->tipe_produk ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div id="topBrandEmptyState" class="col-span-full w-full text-center py-12 px-6 bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center justify-center gap-4 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 text-3xl shadow-inner mb-2 animate-bounce">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-800 font-extrabold text-lg sm:text-xl">Produk akan segera hadir</h3>
                        <p class="text-gray-500 text-xs sm:text-sm mt-1 max-w-md mx-auto">Kami sedang menambahkan produk terbaru untuk brand ini.</p>
                    </div>
                    <a href="https://wa.me/6282288886009" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-xs sm:text-sm rounded-full shadow-md shadow-orange-100 hover:shadow-lg transition-all">
                        <i class="fab fa-whatsapp text-sm"></i>
                        Hubungi Kami
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    @endif
    <!-- ================= END ROW 2.9 ================= -->

    <!-- ================= ROW 3.0 : KENAPA MEMILIH KAMI ================= -->
    <div class="mb-8 md:mb-12 py-10 md:py-16">
        <!-- Section Header -->
        <div class="text-center mb-10 md:mb-14">
            <div class="flex justify-center mb-2 px-4">
                <svg viewBox="0 0 600 120" class="overflow-visible w-full" style="max-width: 500px; height: auto;">
                    <defs>
                        <path id="curve" d="M 50,100 Q 300,0 550,100" fill="transparent" />
                    </defs>
                    <text font-size="42" font-weight="800" fill="#111827" font-family="'Poppins', sans-serif" letter-spacing="1">
                        <textPath href="#curve" startOffset="50%" text-anchor="middle">
                            Kenapa Memilih Kami
                        </textPath>
                    </text>
                </svg>
            </div>
            <p class="text-sm sm:text-base text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Platform belanja online terpercaya dengan harga terbaik, pengiriman cepat, dan layanan maksimal.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="flex justify-center px-4">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6" style="max-width: 960px;">

            <!-- 1. Pembayaran Aman -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/tdesign_secured-filled.svg') }}" alt="Pembayaran Aman" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Pembayaran Aman</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Transaksi aman dan terenkripsi</p>
                    </div>
                </div>
            </div>

            <!-- 2. Pengiriman Cepat -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/iconamoon_delivery-fast-fill.svg') }}" alt="Pengiriman Cepat" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Pengiriman Cepat</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Pengiriman cepat dengan pelacakan</p>
                    </div>
                </div>
            </div>

            <!-- 3. Produk Berkualitas -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/ix_product.svg') }}" alt="Produk Berkualitas" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Produk Berkualitas</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Produk terbaik dengan harga terbaik</p>
                    </div>
                </div>
            </div>

            <!-- 4. Harga Kompetitif -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/entypo_price-ribbon.svg') }}" alt="Harga Kompetitif" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Harga Kompetitif</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Harga terjangkau dan banyak penawaran khusus</p>
                    </div>
                </div>
            </div>

            <!-- 5. Layanan Pelanggan -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/streamline-plump_customer-support-7-solid.svg') }}" alt="Layanan Pelanggan" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Layanan Pelanggan</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Layanan 24/7 siap membantu Anda</p>
                    </div>
                </div>
            </div>

            <!-- 6. Mudah dan Praktis -->
            <div class="group bg-white p-4 sm:p-6 hover:-translate-y-1 transition-all duration-300"
                 style="border-radius: 10px; box-shadow: 0 4px 4px rgba(0,0,0,0.25); width: 100%; min-height: 143px;">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3 sm:gap-4 h-full">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                        <img src="{{ asset('assets/icons/streamline-ultimate_coding-apps-website-browser-image-bold.svg') }}" alt="Mudah dan Praktis" class="w-8 h-8 sm:w-10 sm:h-10">
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1">Mudah dan Praktis</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Website sederhana dan mudah digunakan</p>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>
    <!-- ================= END ROW 3.0 ================= -->


    </div>
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
    // 1. Update active tab styling
    document.querySelectorAll('.brand-tab').forEach(tab => {
        const activeIndicator = tab.querySelector('.active-indicator');
        
        if (tab.dataset.brandId == brandId) {
            const overlayColor = tab.dataset.overlayColor || '#0EA5E9';
            const rgbaOverlay = tab.dataset.rgbaOverlay || 'rgba(14, 165, 233, 0.7)';
            
            const lightBg = rgbaOverlay.replace('0.7', '0.04');
            const softShadow = rgbaOverlay.replace('0.7', '0.15');
            
            tab.className = 'brand-tab flex-shrink-0 group relative flex flex-col items-center justify-between p-4 w-28 h-32 sm:w-32 sm:h-36 rounded-2xl bg-white shadow-xl scale-105 brand-active ring-2 transition-all duration-300';
            tab.style.borderColor = overlayColor;
            tab.style.boxShadow = `0 10px 25px -5px ${softShadow}`;
            tab.style.backgroundColor = lightBg;
            
            if (activeIndicator) {
                activeIndicator.style.backgroundColor = overlayColor;
                activeIndicator.classList.remove('opacity-0', 'scale-x-50');
                activeIndicator.classList.add('opacity-100', 'scale-100');
            }
        } else {
            tab.className = 'brand-tab flex-shrink-0 group relative flex flex-col items-center justify-between p-4 w-28 h-32 sm:w-32 sm:h-36 rounded-2xl bg-white ring-1 ring-gray-100 hover:ring-gray-300 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300';
            tab.style.borderColor = '';
            tab.style.boxShadow = '';
            tab.style.backgroundColor = '';
            
            if (activeIndicator) {
                activeIndicator.style.backgroundColor = '';
                activeIndicator.classList.remove('opacity-100', 'scale-100');
                activeIndicator.classList.add('opacity-0', 'scale-x-50');
            }
        }
    });

    // Update View All link
    const viewAllLink = document.getElementById('viewAllTopBrand');
    if (viewAllLink) {
        viewAllLink.href = `/products?brand=${brandId}`;
    }

    // Get active brand tab elements for dynamic update
    const activeTab = document.querySelector(`.brand-tab[data-brand-id="${brandId}"]`);
    if (activeTab) {
        const heroBanner = document.getElementById('brandHeroBanner');
        const bannerBgContainer = document.getElementById('brandBannerBgContainer');
        const bannerOverlay = document.getElementById('brandBannerOverlay');
        const bannerContent = document.getElementById('brandBannerContent');
        const productsContainer = document.getElementById('topBrandProducts');
        
        // Add fade-out effect for transitions
        heroBanner.style.opacity = '0.5';
        productsContainer.style.opacity = '0.5';
        
        setTimeout(() => {
            const overlayColor = activeTab.dataset.overlayColor || '#0EA5E9';
            const rgbaOverlay = activeTab.dataset.rgbaOverlay || 'rgba(14, 165, 233, 0.7)';
            const bannerImage = activeTab.dataset.bannerImage;
            const bannerTitle = activeTab.dataset.bannerTitle || `${activeTab.dataset.brandName} OFFICIAL`;
            const bannerSubtitle = activeTab.dataset.bannerSubtitle || 'Laptop & Accessories Premium';
            const bannerButtonText = activeTab.dataset.bannerButtonText || 'Lihat Produk';
            const bannerButtonLink = activeTab.dataset.bannerButtonLink || 'javascript:void(0)';
            const showOfficial = activeTab.dataset.showOfficialBadge === '1';

            // Update Banner background
            heroBanner.style.backgroundColor = overlayColor;
            
            if (bannerImage) {
                bannerBgContainer.innerHTML = `<img id="brandBannerBgImg" src="${bannerImage}" alt="Brand Banner Background" class="w-full h-full object-cover transition-all duration-500">`;
            } else {
                bannerBgContainer.innerHTML = `<div id="brandBannerBgImgPlaceholder" class="w-full h-full bg-gradient-to-r from-black/10 via-white/5 to-black/10 opacity-30"></div>`;
            }
            
            // Update Overlay Color & Opacity
            bannerOverlay.style.backgroundColor = rgbaOverlay;
            
            // Update Banner Content
            let officialBadgeHtml = '';
            if (showOfficial) {
                officialBadgeHtml = `
                    <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md px-3.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold uppercase tracking-wider">
                        <i class="fas fa-check-circle text-blue-300"></i> Official Store
                    </span>
                `;
            }
            
            bannerContent.innerHTML = `
                ${officialBadgeHtml}
                <div>
                    <h1 id="brandBannerTitle" class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight drop-shadow-md">
                        ${bannerTitle}
                    </h1>
                    <p id="brandBannerSubtitle" class="text-sm sm:text-base md:text-lg text-white/90 font-light mt-1.5 sm:mt-2 leading-relaxed drop-shadow max-w-xl">
                        ${bannerSubtitle}
                    </p>
                </div>
            `;
            
            // Trigger fade-in
            heroBanner.style.opacity = '1';
        }, 150);
    }

    // Fetch products via AJAX
    fetch(`/home/top-brand-products/${brandId}`)
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById('topBrandProducts');
            
            if (data.products && data.products.length > 0) {
                let productsHtml = '';
                
                data.products.forEach(product => {
                    let imageHtml = '';
                    if (product.image_url) {
                        imageHtml = `<div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                         <img src="${product.image_url}" 
                                              alt="${product.nama_produk}"
                                              class="object-contain max-w-full max-h-full"
                                              loading="lazy">
                                     </div>`;
                    } else {
                        imageHtml = `<div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                         <i class="fas fa-image text-gray-300 text-3xl"></i>
                                     </div>`;
                    }
                    
                    let targetPrice = product.harga_produk;
                    if (product.harga_diskon && product.harga_diskon < product.harga_produk) {
                        targetPrice = product.harga_diskon;
                    }

                    productsHtml += `
                        <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300" data-skeleton-container>
                            <a href="/products/${product.slug}" class="flex flex-col h-full relative group">
                                <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                                    ${imageHtml}
                                </div>
                                <div class="flex flex-col flex-grow p-3 bg-white">
                                    <h3 class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                        ${product.nama_produk}
                                    </h3>
                                    <div class="mt-auto">
                                        <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                        <span class="text-[15px] font-bold text-[#eab308]">
                                            Rp ${parseInt(targetPrice).toLocaleString('id-ID')},00
                                        </span>
                                    </div>
                                    <div class="mt-3 flex flex-col gap-1">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                            <span class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">${product.asal_produk ? product.asal_produk : 'Indonesia'}</span>
                                        </div>
                                        <div class="text-[11px] text-gray-400">
                                            Tipe: ${product.tipe_produk ? product.tipe_produk : '-'}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                });
                
                productsContainer.innerHTML = productsHtml;
            } else {
                productsContainer.innerHTML = `
                    <div id="topBrandEmptyState" class="col-span-full w-full text-center py-12 px-6 bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center justify-center gap-4 transition-all duration-300 animate-fade-in">
                        <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 text-3xl shadow-inner mb-2 animate-bounce">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-800 font-extrabold text-lg sm:text-xl">Produk akan segera hadir</h3>
                            <p class="text-gray-500 text-xs sm:text-sm mt-1 max-w-md mx-auto">Kami sedang menambahkan produk terbaru untuk brand ini.</p>
                        </div>
                        <a href="https://wa.me/6282288886009" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-xs sm:text-sm rounded-full shadow-md shadow-orange-100 hover:shadow-lg transition-all">
                            <i class="fab fa-whatsapp text-sm"></i>
                            Hubungi Kami
                        </a>
                    </div>
                `;
            }
            
            // Remove opacity transition
            productsContainer.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error loading top brand products:', error);
            const productsContainer = document.getElementById('topBrandProducts');
            productsContainer.style.opacity = '1';
        });
}
</script>
@endsection
