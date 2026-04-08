@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Edit Special Deal
        </h2>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        <form action="{{ route('admin.special-deals.update', $specialDeal) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Judul Section
                    </label>
                    <input type="text" name="title" value="{{ $specialDeal->title }}" required
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Subtitle
                    </label>
                    <input type="text" name="subtitle" value="{{ $specialDeal->subtitle }}"
                        placeholder="Contoh: For This Year"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>
            </div>

            <div class="mt-6">
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    <input type="checkbox" name="is_active" {{ $specialDeal->is_active ? 'checked' : '' }} class="mr-2">
                    Aktif
                </label>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Produk dan Diskon</h3>
                
                <!-- Search and Filter Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Search Input -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Cari Produk
                        </label>
                        <input type="text" id="product-search" placeholder="Ketik nama produk..."
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Filter Kategori
                        </label>
                        <select id="category-filter" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                            <option value="">Semua Kategori</option>
                            @php
                                $allCategories = \App\Models\Kategori::withCount('produk')->orderBy('nama_kategori', 'asc')->get();
                            @endphp
                            @foreach($allCategories as $category)
                                <option value="{{ strtolower($category->nama_kategori) }}">
                                    {{ $category->nama_kategori }} ({{ $category->produk_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Brand Filter -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Filter Brand
                        </label>
                        <select id="brand-filter" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                            <option value="">Semua Brand</option>
                            @php
                                $allBrands = \App\Models\Brand::withCount('produk')->orderBy('nama_brand', 'asc')->get();
                            @endphp
                            @foreach($allBrands as $brand)
                                <option value="{{ strtolower($brand->nama_brand) }}">
                                    {{ $brand->nama_brand }} ({{ $brand->produk_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="mb-4">
                    <div class="border rounded-lg p-4 max-h-96 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                        <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                @php
                                    $isSelected = $specialDeal->products->contains($product->id_produk);
                                    $discountPercentage = $isSelected ? $specialDeal->products->firstWhere('id_produk', $product->id_produk)->pivot->discount_percentage : 0;
                                @endphp
                                <div class="product-card bg-white dark:bg-gray-800 rounded-lg border-2 transition-all duration-200 hover:shadow-lg {{ $isSelected ? 'border-blue-500 shadow-md' : 'border-gray-200 dark:border-gray-700' }}" 
                                     data-product-name="{{ strtolower($product->nama_produk) }}" 
                                     data-category="{{ strtolower($product->kategori->nama_kategori ?? '') }}" 
                                     data-brand="{{ strtolower($product->brand->nama_brand ?? '') }}"
                                     data-discount="{{ $discountPercentage }}">
                                    <label class="block cursor-pointer">
                                        <div class="p-4">
                                            <!-- Product Header with Checkbox -->
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id_produk }}" 
                                                        {{ $isSelected ? 'checked' : '' }}
                                                        class="mr-3 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    @if($isSelected)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Dipilih
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Product Image -->
                                            <div class="mb-3">
                                                @if($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->nama_produk }}" 
                                                         class="w-full h-32 object-cover rounded-lg">
                                                @else
                                                    <div class="w-full h-32 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Product Info -->
                                            <div class="space-y-2">
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">{{ $product->nama_produk }}</h4>
                                                    @if($product->kategori)
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->kategori->nama_kategori }}</p>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-lg font-bold text-gray-900 dark:text-white">Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}</p>
                                                        @if($isSelected)
                                                            <p class="text-xs text-green-600 dark:text-green-400 font-medium">
                                                                Diskon {{ $discountPercentage }}% = 
                                                                Rp. {{ number_format($product->harga_produk * (1 - $discountPercentage/100), 0, ',', '.') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($product->brand)
                                                        <div class="text-right">
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">Brand</p>
                                                            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $product->brand->nama_brand }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Stock Status -->
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs {{ $product->stok_produk > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                                        Stok: {{ $product->stok_produk }}
                                                    </span>
                                                    <span class="text-xs px-2 py-1 rounded-full {{ $product->status_produk == 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                        {{ $product->status_produk }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        <div id="no-products-found" class="hidden text-center py-12 text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-lg font-medium">Tidak ada produk yang ditemukan</p>
                            <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian</p>
                        </div>
                    </div>
                </div>

                <!-- Discount Percentage Input -->
                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                        Persentase Diskon (%)
                    </label>
                    <input type="number" name="discount_percentage" min="1" max="100" required
                        value="{{ $specialDeal->products->isNotEmpty() ? $specialDeal->products->first()->pivot->discount_percentage : '' }}"
                        placeholder="Masukkan persentase diskon untuk semua produk yang dipilih"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Diskon ini akan diterapkan ke semua produk yang Anda centang di atas
                    </p>
                </div>

                <!-- Selected Products Summary & Actions -->
                <div class="mb-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    Produk yang dipilih: <span id="selected-count" class="font-bold">{{ $specialDeal->products->count() }}</span>
                                </span>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                    dari {{ $products->count() }} produk total
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" onclick="selectAllVisibleProducts()" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilih Semua (Tampil)
                                </button>
                                <button type="button" onclick="selectAllProducts()" 
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    Pilih Semua Produk
                                </button>
                                <button type="button" onclick="deselectAllProducts()" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal Semua
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.special-deals.index') }}" 
                    class="inline-flex items-center justify-center rounded-md bg-gray-500 py-4 px-10 text-center font-medium text-white hover:bg-opacity-90">
                    Batal
                </a>
                <button type="submit" 
                    class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90">
                    Update
                </button>
            </div>
        </form>
    </div>

    <script>
        // Filter functionality
        function filterProducts() {
            const searchTerm = document.getElementById('product-search').value.toLowerCase();
            const categoryFilter = document.getElementById('category-filter').value.toLowerCase();
            const brandFilter = document.getElementById('brand-filter').value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            const noProductsFound = document.getElementById('no-products-found');
            let visibleCount = 0;

            productCards.forEach(function(card) {
                const productName = card.getAttribute('data-product-name');
                const category = card.getAttribute('data-category');
                const brand = card.getAttribute('data-brand');
                
                const matchesSearch = !searchTerm || productName.includes(searchTerm);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesBrand = !brandFilter || brand === brandFilter;
                
                if (matchesSearch && matchesCategory && matchesBrand) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide "no products found" message
            if (visibleCount === 0) {
                noProductsFound.classList.remove('hidden');
            } else {
                noProductsFound.classList.add('hidden');
            }
        }

        // Add event listeners for filters
        document.addEventListener('DOMContentLoaded', function() {
            // Search input
            document.getElementById('product-search').addEventListener('input', filterProducts);
            
            // Category filter
            document.getElementById('category-filter').addEventListener('change', filterProducts);
            
            // Brand filter
            document.getElementById('brand-filter').addEventListener('change', filterProducts);
            
            // Checkbox change handlers
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    updateCardVisualState(this);
                });
            });
            
            // Initialize count and visual states
            updateSelectedCount();
            checkboxes.forEach(function(checkbox) {
                updateCardVisualState(checkbox);
            });
        });

        // Update card visual state based on checkbox
        function updateCardVisualState(checkbox) {
            const card = checkbox.closest('.product-card');
            const selectedBadge = card.querySelector('.bg-blue-100, .bg-blue-900');
            
            if (checkbox.checked) {
                card.classList.add('border-blue-500', 'shadow-md');
                card.classList.remove('border-gray-200', 'dark:border-gray-700');
                if (selectedBadge) {
                    selectedBadge.style.display = 'inline-flex';
                }
            } else {
                card.classList.remove('border-blue-500', 'shadow-md');
                card.classList.add('border-gray-200', 'dark:border-gray-700');
                if (selectedBadge) {
                    selectedBadge.style.display = 'none';
                }
            }
        }

        // Update selected count when checkboxes change
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
            const selectedCount = document.getElementById('selected-count');
            selectedCount.textContent = checkboxes.length;
        }

        // Select all visible products functionality
        function selectAllVisibleProducts() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            const visibleCheckboxes = Array.from(checkboxes).filter(function(checkbox) {
                const card = checkbox.closest('.product-card');
                return card.style.display !== 'none';
            });

            visibleCheckboxes.forEach(function(checkbox) {
                checkbox.checked = true;
                updateCardVisualState(checkbox);
            });

            updateSelectedCount();
        }

        // Select all products functionality (including hidden ones)
        function selectAllProducts() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
                updateCardVisualState(checkbox);
            });

            updateSelectedCount();
        }

        // Deselect all products functionality
        function deselectAllProducts() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                updateCardVisualState(checkbox);
            });

            updateSelectedCount();
        }

        // Form validation - ensure at least one product is selected
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu produk untuk Special Deal.');
                return false;
            }
        });
    </script>
@endsection
