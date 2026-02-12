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
                    
                    @forelse($banners as $banner)
                        <div class="w-full h-full flex-shrink-0 relative">

                            @if(Str::startsWith($banner->gambar_banner, 'http'))
                                <img src="{{ $banner->gambar_banner }}" 
                                     alt="Banner"
                                     class="w-full h-full object-cover">

                            @elseif(file_exists(public_path('storage/images/' . $banner->gambar_banner)))
                                <img src="{{ asset('storage/images/' . $banner->gambar_banner) }}" 
                                     alt="Banner"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-400">
                                    <div class="text-center px-4">
                                        <i class="fas fa-image text-4xl sm:text-6xl mb-2 sm:mb-4"></i>
                                        <p class="font-bold text-sm sm:text-xl">Banner Image</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @empty
                        <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-400">
                            <div class="text-center px-4">
                                <i class="fas fa-images text-4xl sm:text-6xl mb-2 sm:mb-4"></i>
                                <p class="font-bold text-sm sm:text-xl">No Banners Available</p>
                            </div>
                        </div>
                    @endforelse

                </div>

                <!-- Controls -->
                @if($banners->count() > 1)
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


    <!-- ================= ROW 2 : PRODUCT FULL WIDTH ================= -->
    <div class="mb-8 md:mb-12">

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-star text-orange-500 text-lg sm:text-xl"></i>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                    New Arrival Products
                </h2>
            </div>

            <a href="{{ route('products.index') }}" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                View All
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-4">
            @forelse($products as $product)
                <div class="flex flex-col bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300" data-skeleton-container>
                    <a href="{{ route('products.show', $product->id_produk) }}" class="block w-full h-full">
                        <!-- Product Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <!-- Skeleton Loading -->
                            <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0 z-10"></div>

                            <img src="{{ asset('storage/images/frame.png') }}" alt="Frame" class="absolute inset-0 w-full h-full object-contain">
                            
                            @php
                                $imagePath = null;
                                if ($product->gambar_produk) {
                                    // 1. Try exact match
                                    $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                    
                                    // 2. Try removing spaces (e.g. "PLC with VFD" -> "PLCwithVFD")
                                    $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                    
                                    // 3. Try lowercase no spaces (e.g. "Video Wall" -> "videowall")
                                    $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                    
                                    if (file_exists(public_path($path1))) {
                                        $imagePath = $path1;
                                    } elseif (file_exists(public_path($path2))) {
                                        $imagePath = $path2;
                                    } elseif (file_exists(public_path($path3))) {
                                        $imagePath = $path3;
                                    }
                                }
                            @endphp

                            @if($imagePath)
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset($imagePath) }}"
                                         alt="{{ $product->nama_produk }}"
                                         data-skeleton-image
                                         class="object-contain w-full h-full"
                                         style="display: none; transform: scale(0.75); transform-origin: center;">
                                </div>
                            @else
                                <div data-fallback-image class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50 absolute inset-0 z-0" style="display: none;">
                                    <img src="{{ asset('hitam-putih.svg') }}" 
                                         alt="No Image" 
                                         class="w-12 h-12 sm:w-20 sm:h-20 object-contain opacity-60">
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset('hitam-putih.svg') }}" 
                                         alt="{{ $product->nama_produk }}"
                                         data-skeleton-image
                                         class="object-contain w-12 h-12 sm:w-20 sm:h-20 opacity-60"
                                         style="display: block;">
                                </div>
                            @endif
                            
                            <!-- Badges (Optional) -->
                            @if($product->stok_produk <= 0)
                                <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 sm:py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    Habis
                                </div>
                            @elseif($product->harga_produk < 100000) 
                                <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-green-500 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 sm:py-1 rounded-full uppercase tracking-wider shadow-sm">
                                    Hemat
                                </div>
                            @endif
                        </div>
    
                        <!-- Product Info -->
                        <div class="p-2 sm:p-3 flex flex-col flex-grow">
                            <!-- Category/Brand (Meta) -->
                            <div class="text-[8px] sm:text-[10px] text-gray-400 mb-1 uppercase tracking-wide font-semibold line-clamp-1">
                                {{ $product->brand->nama_brand ?? 'Generic' }}
                            </div>
    
                            <!-- Title -->
                            <h3 class="font-medium text-gray-800 text-xs sm:text-sm leading-snug mb-2 line-clamp-2 min-h-[2em] sm:min-h-[2.5em] group-hover:text-orange-600 transition-colors">
                                {{ $product->nama_produk }}
                            </h3>
    
                            <!-- Bottom Section (Price & Stock pushed to bottom) -->
                            <div class="mt-auto pt-1 sm:pt-2 border-t border-gray-50 flex items-center justify-between">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[7px] sm:text-xs text-gray-400 line-through">Rp {{ number_format(($product->harga_produk * 1.2), 0, ',', '.') }}</span>
                                    <span class="text-orange-600 font-bold text-xs sm:text-sm">
                                        Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                    </span>
                                </div>
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
    <!-- ================= END ROW 2 ================= -->

   <!-- ================= ROW 3 : OFFICIAL STORE ================= -->
        <div class="mb-8 md:mb-12">
            
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 mb-4 md:mb-6">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg p-1.5 flex items-center justify-center shadow-sm" style="background-color:#F7931E; min-width: 36px; min-height: 36px;">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 leading-none">
                            Official Store
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Temukan Banyak Pilihan di Toko-Toko Resmi Kami
                        </p>
                    </div>
                </div>
            </div>

            <!-- Brand Logos Horizontal Scroll -->
            <div class="relative">
                <!-- Brand Container -->
                <div id="official-store-container" class="relative flex gap-3 overflow-x-auto pb-4 px-1 scrollbar-hide snap-x" style="-ms-overflow-style: none; scrollbar-width: none;">
                    <style>
                        .scrollbar-hide::-webkit-scrollbar { display: none; }
                        .brand-card {
                            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                    </style>
                    
                    @forelse($brands as $index => $brand)
                        <!-- Card with Dynamic Width -->
                        <div class="flex-shrink-0 group snap-start brand-card" 
                             data-index="{{ $index }}"
                             onmouseenter="expandBrandCard(this)"
                             style="width: {{ $loop->first ? '280px' : '141px' }}; min-width: 141px;">
                            
                            <a href="#" onclick="showBrandProducts({{ $brand->id_brand }}, document.querySelector('.brand-tab[data-brand-id=\'{{ $brand->id_brand }}\']')); return false;" class="block bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 overflow-hidden h-full relative">
                                
                                <!-- Background Image (Fixed height) -->
                                <div class="relative overflow-hidden bg-gray-100" style="height: 211px;">
                                    @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                        <img src="{{ asset('storage/images/' . $brand->gambar_background) }}" 
                                             alt="{{ $brand->nama_brand }} Background" 
                                             class="w-full h-full object-cover transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-300"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                </div>
                                
                                <!-- Logo + Name Container (Fixed height) -->
                                <div class="relative px-2 pb-4 pt-10 text-center bg-white flex flex-col justify-start items-center" style="height: 100px;">
                                    
                                    <!-- Floating Logo Box -->
                                    <div class="absolute left-1/2 -translate-x-1/2 bg-white rounded-md shadow-md border border-gray-50 flex items-center justify-center p-1 z-10" style="top: -24px; width: 48px; height: 48px;">
                                        @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                            <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" 
                                                 alt="{{ $brand->nama_brand }}" 
                                                 class="w-full h-full object-contain p-0.5">
                                        @else
                                            <i class="fas fa-store text-gray-400 text-lg"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="flex-shrink-0 w-full text-center py-6 sm:py-8 border border-dashed border-gray-300 rounded-lg">
                            <i class="fas fa-store text-gray-300 text-4xl sm:text-5xl mb-2 sm:mb-4"></i>
                            <p class="text-gray-500 text-sm sm:text-base">No brands available</p>
                        </div>
                    @endforelse
                    
                </div>
            </div>
            
            <script>
                function expandBrandCard(element) {
                    // Get container
                    const container = document.getElementById('official-store-container');
                    const cards = container.querySelectorAll('.brand-card');
                    
                    // Reset all cards to default width
                    cards.forEach(card => {
                        card.style.width = '141px';
                    });
                    
                    // Expand the hovered card
                    element.style.width = '280px';
                }
            </script>
            
        </div>
        <!-- ================= END ROW 3 ================= -->

    <!-- ================= ROW 4 : POPULAR BRANDS ================= -->
    <div class="mb-8 md:mb-12">
        
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-fire text-orange-500 text-lg sm:text-xl"></i>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                    Popular Brands
                </h2>
            </div>

            <a href="{{ route('products.index') }}" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                View All
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Brand Tabs -->
        <div class="border-b border-gray-200 mb-4 md:mb-6 overflow-x-auto">
            <div class="flex gap-2 sm:gap-6 pb-2">
                @forelse($brands as $index => $brand)
                    <button 
                        class="brand-tab px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                               {{ $index == 0 ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
                        data-brand-id="{{ $brand->id_brand }}"
                        onclick="showBrandProducts({{ $brand->id_brand }}, this)">
                        {{ $brand->nama_brand }}
                    </button>
                @empty
                    <p class="text-gray-500 text-sm">No brands available</p>
                @endforelse
            </div>
        </div>

        <!-- Products Container -->
        <div id="brandProductsContainer">
            <!-- Products will be dynamically loaded here -->
        </div>
        
    </div>
    <!-- ================= END ROW 4 ================= -->

</div>



<!-- ================= SLIDER SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const slider = document.getElementById('bannerSlider');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let index = 0;
    const total = {{ $banners->count() }};

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

// Brand Products Data
const productsByBrand = @json($productsByBrand);
const frameUrl = "{{ asset('storage/images/frame.png') }}";
const fallbackIconUrl = "{{ asset('hitam-putih.svg') }}";

// Show products for selected brand
function showBrandProducts(brandId, tabElement) {
    // Update active tab styling
    document.querySelectorAll('.brand-tab').forEach(tab => {
        tab.classList.remove('border-orange-500', 'text-orange-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    tabElement.classList.remove('border-transparent', 'text-gray-500');
    tabElement.classList.add('border-orange-500', 'text-orange-600');
    
    // Get products for this brand
    const products = productsByBrand[brandId] || [];
    
    // Generate product HTML
    let productsHtml = '<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-4">';
    
    if (products.length > 0) {
        products.forEach(product => {
            const imageUrl = product.gambar_produk ? `/storage/images/produk/${product.gambar_produk}` : null;
            
            productsHtml += `
                <div class="flex flex-col bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <a href="/products/${product.id_produk}" class="block w-full h-full">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="${frameUrl}" alt="Frame" class="absolute inset-0 w-full h-full object-contain">
                            ${imageUrl ? 
                                `<div class="absolute inset-0 flex items-center justify-center">
                                    <img src="${imageUrl}" alt="${product.nama_produk}" class="object-contain w-full h-full" style="transform: scale(0.75); transform-origin: center;">
                                </div>` :
                                `<div class="absolute inset-0 flex items-center justify-center">
                                    <img src="${fallbackIconUrl}" alt="No Image" class="w-12 h-12 sm:w-16 sm:h-16 object-contain opacity-60">
                                </div>`
                            }
                        </div>
                        <div class="p-2 sm:p-3 flex flex-col flex-grow">
                            <!-- Category/Brand -->
                            <div class="text-[8px] sm:text-[10px] text-gray-400 mb-1 uppercase tracking-wide font-semibold line-clamp-1">
                                ${product.brand?.nama_brand || 'Generic'}
                            </div>
    
                            <h3 class="font-medium text-gray-800 text-xs sm:text-sm leading-snug mb-2 line-clamp-2 min-h-[2em] sm:min-h-[2.5em] group-hover:text-orange-600 transition-colors">
                                ${product.nama_produk}
                            </h3>
    
                            <div class="mt-auto pt-1 sm:pt-2 border-t border-gray-50 flex items-center justify-between">
                                 <div class="flex flex-col gap-0.5">
                                    <span class="text-[7px] sm:text-xs text-gray-400 line-through">Rp ${Number((product.harga_produk || 0) * 1.2).toLocaleString('id-ID')}</span>
                                    <span class="text-orange-600 font-bold text-xs sm:text-sm">
                                        Rp ${Number(product.harga_produk || 0).toLocaleString('id-ID')}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        });
    } else {
        productsHtml += `
            <div class="col-span-2 sm:col-span-3 lg:col-span-6 w-full text-center py-8 sm:py-12 bg-white rounded-lg sm:rounded-xl border border-dashed border-gray-300">
                <i class="fas fa-box-open text-gray-300 text-4xl sm:text-5xl mb-2 sm:mb-4"></i>
                <p class="text-gray-500 font-medium text-sm sm:text-base">Belum ada produk untuk brand ini.</p>
            </div>
        `;
    }
    
    productsHtml += '</div>';
    
    // Update container
    document.getElementById('brandProductsContainer').innerHTML = productsHtml;
}

// Load first brand products on page load
document.addEventListener('DOMContentLoaded', function() {
    const firstTab = document.querySelector('.brand-tab');
    if (firstTab) {
        const firstBrandId = firstTab.dataset.brandId;
        showBrandProducts(firstBrandId, firstTab);
    }
});
</script>
@endsection
