@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 768px) {
            .products-row-layout {
                --sidebar-width: 30%;
            }

            .products-row-layout .products-sidebar {
                flex: 0 0 var(--sidebar-width);
                max-width: var(--sidebar-width);
            }

            .products-row-layout .products-content {
                flex: 1 1 0;
                min-width: 0;
            }
        }
    </style>
    <div class="container mx-auto px-2 sm:px-4">
        <div class="products-row-layout flex flex-col md:flex-row gap-4 md:gap-6 relative"
            style="--sidebar-width: 30%; --sidebar-gap: 1.5rem;">
            <!-- Sidebar -->
            <aside class="products-sidebar w-full hidden md:block">
                @include('partials.sidebar')
                @include('partials.product-filters')
            </aside>

            <!-- Main Content -->
            <div class="products-content w-full">
                <!-- Breadcrumbs / Title -->
                <div class="mb-4 md:mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <h1 class="text-lg sm:text-xl font-bold text-gray-800">
                        @if(request('category'))
                            Kategori: {{ request('category') }}
                        @elseif(request('search'))
                            Hasil Pencarian: "{{ request('search') }}"
                        @else
                            Semua Produk
                        @endif
                    </h1>
                    <div class="text-xs sm:text-sm text-gray-500">
                        Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari
                        {{ $products->total() }} produk
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4 md:gap-6">
                        @foreach($products as $product)
                            <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300"
                                data-skeleton-container>
                                <a href="{{ route('products.show', $product->slug) }}" class="flex flex-col h-full relative group">
                                    <!-- Product Image -->
                                    <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                                        @if(isset($product) && $product->image_url)
                                            <div data-skeleton
                                                class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0"
                                                style="z-index: 30;"></div>
                                            <div class="absolute inset-0 flex items-center justify-center bg-gray-50"
                                                style="z-index: 10;">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->nama_produk }}"
                                                    class="object-contain max-w-full max-h-full" data-skeleton-image loading="lazy">
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
                                                <span
                                                    class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $product->asal_produk ?: 'Indonesia' }}</span>
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

                    <div class="mt-6 md:mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-search text-gray-300 text-5xl sm:text-6xl mb-2 sm:mb-4"></i>
                        <h3 class="text-base sm:text-lg font-medium text-gray-600">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-500 mt-2 text-sm sm:text-base">Coba kata kunci lain atau reset filter.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block mt-4 px-4 sm:px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm sm:text-base">Lihat
                            Semua Produk</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the search form from header
    const searchForm = document.querySelector('form[action="{{ route('products.index') }}"]');
    const searchInput = searchForm?.querySelector('input[name="search"]');
    const categorySelect = searchForm?.querySelector('select[name="category"]');
    const productsContainer = document.querySelector('.grid.grid-cols-2');
    const titleElement = document.querySelector('h1.text-gray-800');
    const countElement = document.querySelector('.text-gray-500');
    
    if (!searchForm || !searchInput || !productsContainer) return;
    
    let searchTimeout;
    
    // Function to perform AJAX search
    function performSearch() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            const searchTerm = searchInput.value.trim();
            const category = categorySelect?.value || '';
            
            // Build query parameters
            const params = new URLSearchParams();
            if (searchTerm) params.append('search', searchTerm);
            if (category) params.append('category', category);
            
            // Show loading state
            productsContainer.style.opacity = '0.5';
            
            // Perform AJAX request
            fetch(`{{ route('products.index') }}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse the response HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update products grid
                const newProductsContainer = doc.querySelector('.grid.grid-cols-2');
                if (newProductsContainer) {
                    productsContainer.innerHTML = newProductsContainer.innerHTML;
                    productsContainer.style.opacity = '1';
                }
                
                // Update title
                const newTitleElement = doc.querySelector('h1.text-gray-800');
                if (newTitleElement && titleElement) {
                    titleElement.innerHTML = newTitleElement.innerHTML;
                }
                
                // Update count
                const newCountElement = doc.querySelector('.text-gray-500');
                if (newCountElement && countElement) {
                    countElement.innerHTML = newCountElement.innerHTML;
                }
                
                // Update pagination
                const newPagination = doc.querySelector('.mt-6');
                const currentPagination = document.querySelector('.mt-6');
                if (newPagination && currentPagination) {
                    currentPagination.innerHTML = newPagination.innerHTML;
                }
                
                // Update URL without page reload
                const newUrl = params.toString() ? `?${params.toString()}` : window.location.pathname;
                window.history.pushState({}, '', newUrl);
            })
            .catch(error => {
                console.error('Search error:', error);
                productsContainer.style.opacity = '1';
            });
        }, 300); // Debounce for 300ms
    }
    
    // Listen for search input changes
    searchInput.addEventListener('input', performSearch);
    
    // Listen for category changes
    if (categorySelect) {
        categorySelect.addEventListener('change', performSearch);
    }
    
    // Handle browser back/forward
    window.addEventListener('popstate', function() {
        // Reload the page when user navigates back/forward
        window.location.reload();
    });
});
</script>
@endpush