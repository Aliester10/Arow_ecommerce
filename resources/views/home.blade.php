@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4">

    <!-- ================= ROW 1 : SIDEBAR + BANNER ================= -->
    <div class="flex flex-col md:flex-row gap-4 md:gap-6 mb-8 md:mb-10">

        <!-- Sidebar Categories -->
        <aside class="w-full md:w-1/4 hidden md:block">
            @include('partials.sidebar')
        </aside>

        <!-- Banner -->
        <div class="w-full md:w-3/4">
            <div class="relative bg-gray-200 rounded-lg md:rounded-xl overflow-hidden shadow-sm h-40 sm:h-64 md:h-96 group">

                <!-- Slider Container -->
                <div id="bannerSlider" class="h-full flex transition-transform duration-500 ease-in-out">
                    
                    @forelse($banners as $banner)
                        <div class="w-full h-full flex-shrink-0 relative">

                            @if(Str::startsWith($banner->gambar_banner, 'http'))
                                <img src="{{ $banner->gambar_banner }}" 
                                     alt="Banner"
                                     class="w-full h-full object-cover">

                            @elseif(file_exists(public_path('storage/' . $banner->gambar_banner)))
                                <img src="{{ asset('storage/' . $banner->gambar_banner) }}" 
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

            <a href="#" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                View All
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-4">
            @forelse($products as $product)
                <div class="flex flex-col bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300" data-skeleton-container>

                    <!-- Product Image -->
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        <!-- Skeleton Loading -->
                        <div data-skeleton class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0 z-10"></div>

                        @if($product->gambar_produk && file_exists(public_path('storage/produk/' . $product->gambar_produk)))
                            <img src="{{ asset('storage/produk/' . $product->gambar_produk) }}"
                                 alt="{{ $product->nama_produk }}"
                                 data-skeleton-image
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 style="display: none;">
                        @else
                            <div data-fallback-image class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50 absolute inset-0 z-0" style="display: none;">
                                <img src="{{ asset('hitam-putih.svg') }}" 
                                     alt="No Image" 
                                     class="w-12 h-12 sm:w-20 sm:h-20 object-contain opacity-60">
                            </div>
                            <img src="{{ asset('hitam-putih.svg') }}" 
                                 alt="{{ $product->nama_produk }}"
                                 data-skeleton-image
                                 class="w-full h-full object-contain p-4 sm:p-8 bg-white"
                                 style="display: block;">
                        @endif
                        
                        <!-- Badges (Optional) -->
                        @if($product->stok <= 0)
                            <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 sm:py-1 rounded-full uppercase tracking-wider shadow-sm">
                                Habis
                            </div>
                        @elseif($product->harga < 100000) 
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
                                <span class="text-[7px] sm:text-xs text-gray-400 line-through">Rp {{ number_format(($product->harga * 1.2), 0, ',', '.') }}</span>
                                <span class="text-orange-600 font-bold text-xs sm:text-sm">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

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
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 md:mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-store text-orange-500 text-lg sm:text-xl"></i>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                    Official Store
                </h2>
            </div>

            <a href="#" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
                View All
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

        <!-- Brand Logos Horizontal Scroll -->
        <div class="relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-blue-50 rounded-lg sm:rounded-xl opacity-30"></div>
            
            <!-- Brand Container -->
            <div class="relative flex gap-2 sm:gap-4 overflow-x-auto pb-2 sm:pb-4 px-2 sm:px-6">
                
                @forelse($brands as $brand)
                    <div class="flex-shrink-0 group">
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 p-3 sm:p-4 text-center min-w-[100px] sm:min-w-[120px]">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-1 sm:mb-2 flex items-center justify-center">
                                @if($brand->logo_brand && file_exists(public_path('storage/' . $brand->logo_brand)))
                                    <img src="{{ asset('storage/' . $brand->logo_brand) }}" 
                                         alt="{{ $brand->nama_brand }}" 
                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-store text-gray-400 text-sm sm:text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <p class="text-[10px] sm:text-xs font-medium text-gray-700 group-hover:text-orange-600 transition-colors line-clamp-1">
                                {{ $brand->nama_brand }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex-shrink-0 w-full text-center py-6 sm:py-8">
                        <i class="fas fa-store text-gray-300 text-4xl sm:text-5xl mb-2 sm:mb-4"></i>
                        <p class="text-gray-500 text-sm sm:text-base">No brands available</p>
                    </div>
                @endforelse
                
            </div>
        </div>
        
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

            <a href="#" class="text-orange-500 hover:text-orange-600 font-medium flex items-center gap-1 text-sm sm:text-base">
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
            const imageUrl = product.gambar_produk ? `/storage/produk/${product.gambar_produk}` : null;
            
            productsHtml += `
                <div class="flex flex-col bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        ${imageUrl ? 
                            `<img src="${imageUrl}" alt="${product.nama_produk}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">` :
                            `<div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                <img src="{{ asset('hitam-putih.svg') }}" alt="No Image" class="w-12 h-12 sm:w-16 sm:h-16 object-contain opacity-60">
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
                                <span class="text-[7px] sm:text-xs text-gray-400 line-through">Rp ${Number((product.harga || 0) * 1.2).toLocaleString('id-ID')}</span>
                                <span class="text-orange-600 font-bold text-xs sm:text-sm">
                                    Rp ${Number(product.harga || 0).toLocaleString('id-ID')}
                                </span>
                            </div>
                        </div>
                    </div>
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
