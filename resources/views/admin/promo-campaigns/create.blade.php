@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Tambah Promo Campaign
        </h2>
    </div>

    @if($errors->any())
        <div class="flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-6">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#F87171]">
                <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#F87171]">
                    Error Validasi
                </h5>
                <ul class="list-disc list-inside text-sm text-body">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        <form action="{{ route('admin.promo-campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Nama Promo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Promo Ramadhan"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <!-- Slug -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Slug (Otomatis dari Nama)
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required readonly placeholder="promo-ramadhan"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-gray-100 py-3 px-5 font-medium text-black outline-none transition dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Subtitle -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Subtitle
                    </label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Contoh: Hemat s/d 50% untuk furniture"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <!-- Banner -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Banner Promo (Opsional)
                    </label>
                    <input type="file" name="banner" accept="image/*"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <!-- Start Date -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <!-- End Date -->
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Tanggal Berakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    Deskripsi
                </label>
                <textarea name="description" rows="3" placeholder="Masukkan deskripsi promo..."
                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">{{ old('description') }}</textarea>
            </div>

            <!-- Status Toggle -->
            <div class="mt-6">
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    Status
                </label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="status" value="aktif" class="mr-2" {{ old('status', 'aktif') === 'aktif' ? 'checked' : '' }}>
                        Aktif
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="status" value="nonaktif" class="mr-2" {{ old('status') === 'nonaktif' ? 'checked' : '' }}>
                        Nonaktif
                    </label>
                </div>
            </div>

            <!-- Products Section -->
            <div class="mt-8 border-t border-stroke pt-6 dark:border-gray-700">
                <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Produk Promo</h3>
                
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
                                $allCategories = \App\Models\Kategori::with('subkategori.subSubkategori.produk')->orderBy('nama_kategori', 'asc')->get();
                            @endphp
                            @foreach($allCategories as $category)
                                @php
                                    $produkCount = $category->subkategori->flatMap(function($sub) {
                                        return $sub->subSubkategori->flatMap(function($subSub) {
                                            return $subSub->produk;
                                        });
                                    })->count();
                                @endphp
                                <option value="{{ strtolower($category->nama_kategori) }}">
                                    {{ $category->nama_kategori }} ({{ $produkCount }})
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

                <!-- Product selection count -->
                <div class="mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                Produk yang dipilih: <span id="selected-count" class="font-bold">0</span>
                            </span>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                dari {{ $products->count() }} produk total
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="selectAllVisibleProducts()" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                Pilih Semua (Tampil)
                            </button>
                            <button type="button" onclick="deselectAllProducts()" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                                Batal Semua
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="mb-6">
                    <div class="border border-stroke rounded-lg p-4 max-h-125 overflow-y-auto bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                        <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $oldSelected = old('selected_products', []);
                                $oldTypes = old('discount_type', []);
                                $oldValues = old('discount_value', []);
                            @endphp
                            @foreach($products as $product)
                                @php
                                    $isOldChecked = in_array($product->id_produk, $oldSelected);
                                    $oldType = $oldTypes[$product->id_produk] ?? 'percent';
                                    $oldVal = $oldValues[$product->id_produk] ?? 0;
                                @endphp
                                <div class="product-card bg-white dark:bg-gray-800 rounded-lg border-2 transition-all duration-200 hover:shadow-md {{ $isOldChecked ? 'border-blue-500 shadow-md' : 'border-gray-200 dark:border-gray-700' }}" 
                                     data-product-id="{{ $product->id_produk }}"
                                     data-product-name="{{ strtolower($product->nama_produk) }}" 
                                     data-category="{{ strtolower($product->kategori->nama_kategori ?? '') }}" 
                                     data-brand="{{ strtolower($product->brand->nama_brand ?? '') }}">
                                    
                                    <div class="p-4">
                                        <!-- Product Header with Checkbox -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center">
                                                <input type="checkbox" name="selected_products[]" value="{{ $product->id_produk }}" 
                                                    class="mr-3 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 product-checkbox"
                                                    {{ $isOldChecked ? 'checked' : '' }}
                                                    onchange="toggleProductInputs(this)">
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Pilih Produk</span>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 selected-badge" style="display: {{ $isOldChecked ? 'inline-flex' : 'none' }};">
                                                Dipilih
                                            </span>
                                        </div>
                                        
                                        <!-- Product Image & Basic Info -->
                                        <div class="flex gap-3 mb-3">
                                            <div class="w-16 h-16 flex-shrink-0">
                                                @if($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->nama_produk }}" 
                                                         class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow">
                                                <h4 class="font-semibold text-gray-900 dark:text-white text-xs line-clamp-2">{{ $product->nama_produk }}</h4>
                                                <p class="text-[10px] text-gray-500 dark:text-gray-400">
                                                    {{ $product->kategori->nama_kategori ?? '-' }} | {{ $product->brand->nama_brand ?? '-' }}
                                                </p>
                                                <!-- Overlap warning message -->
                                                <div class="overlap-warning text-[10px] text-red-600 dark:text-red-400 font-bold mt-1" style="display: none;">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> Promo aktif: <span class="overlap-campaign-name"></span>
                                                </div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">
                                                    Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Discount Configuration -->
                                        <div class="mt-2 space-y-2 border-t border-stroke pt-2 dark:border-gray-700 discount-config" style="opacity: {{ $isOldChecked ? '1' : '0.5' }}; pointer-events: {{ $isOldChecked ? 'auto' : 'none' }};">
                                            <div class="flex gap-4 items-center">
                                                <label class="inline-flex items-center text-xs font-medium cursor-pointer text-black dark:text-white">
                                                    <input type="radio" name="discount_type[{{ $product->id_produk }}]" value="percent" class="mr-1 discount-type-radio" data-product-id="{{ $product->id_produk }}" onchange="updateDiscountPreview({{ $product->id_produk }})" {{ $oldType === 'percent' ? 'checked' : '' }} {{ !$isOldChecked ? 'disabled' : '' }}>
                                                    % Persen
                                                </label>
                                                <label class="inline-flex items-center text-xs font-medium cursor-pointer text-black dark:text-white">
                                                    <input type="radio" name="discount_type[{{ $product->id_produk }}]" value="nominal" class="mr-1 discount-type-radio" data-product-id="{{ $product->id_produk }}" onchange="updateDiscountPreview({{ $product->id_produk }})" {{ $oldType === 'nominal' ? 'checked' : '' }} {{ !$isOldChecked ? 'disabled' : '' }}>
                                                    Nominal (Rp)
                                                </label>
                                            </div>
                                            <div>
                                                <input type="number" name="discount_value[{{ $product->id_produk }}]" value="{{ $oldVal }}" min="0" {{ !$isOldChecked ? 'disabled' : '' }}
                                                    class="w-full rounded-md border border-stroke bg-transparent py-1 px-3 text-xs outline-none transition focus:border-primary discount-value-input text-black dark:text-white dark:border-gray-600" 
                                                    data-product-id="{{ $product->id_produk }}" data-original-price="{{ $product->harga_produk }}" oninput="updateDiscountPreview({{ $product->id_produk }})">
                                            </div>
                                            <div class="text-xs font-semibold text-green-600 dark:text-green-400 mt-1">
                                                Harga Promo: <span class="discount-preview-price" data-product-id="{{ $product->id_produk }}">Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div id="no-products-found" class="hidden text-center py-12 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-box-open text-5xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium">Tidak ada produk yang ditemukan</p>
                            <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 py-4">
                <a href="{{ route('admin.promo-campaigns.index') }}" 
                    class="inline-flex items-center justify-center rounded-md bg-gray-500 py-4 px-10 text-center font-medium text-white hover:bg-opacity-90">
                    Batal
                </a>
                <button type="submit" 
                    class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from name/title
        document.getElementById('title').addEventListener('input', function() {
            const titleValue = this.value;
            const slugValue = titleValue
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // remove invalid characters
                .replace(/\s+/g, '-')         // replace spaces with hyphens
                .replace(/-+/g, '-');         // collapse multiple hyphens
            document.getElementById('slug').value = slugValue;
        });

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
            document.getElementById('product-search').addEventListener('input', filterProducts);
            document.getElementById('category-filter').addEventListener('change', filterProducts);
            document.getElementById('brand-filter').addEventListener('change', filterProducts);
            document.getElementById('start_date').addEventListener('change', checkOverlappingProducts);
            document.getElementById('end_date').addEventListener('change', checkOverlappingProducts);
            document.querySelectorAll('input[name="status"]').forEach(r => r.addEventListener('change', checkOverlappingProducts));
            
            // Initial counts
            updateSelectedCount();
            
            // Initial previews for pre-checked old entries
            document.querySelectorAll('.product-checkbox:checked').forEach(function(chk) {
                updateDiscountPreview(chk.value);
            });

            // Initial overlap check
            checkOverlappingProducts();
        });

        // Toggle configuration inputs based on checkbox
        function toggleProductInputs(checkbox) {
            const productId = checkbox.value;
            const card = checkbox.closest('.product-card');
            const configBlock = card.querySelector('.discount-config');
            const radios = configBlock.querySelectorAll('.discount-type-radio');
            const input = configBlock.querySelector('.discount-value-input');
            const selectedBadge = card.querySelector('.selected-badge');

            if (checkbox.checked) {
                configBlock.style.opacity = '1';
                configBlock.style.pointerEvents = 'auto';
                radios.forEach(r => r.disabled = false);
                input.disabled = false;
                card.classList.add('border-blue-500', 'shadow-md');
                card.classList.remove('border-gray-200', 'dark:border-gray-700');
                selectedBadge.style.display = 'inline-flex';
                updateDiscountPreview(productId);
            } else {
                configBlock.style.opacity = '0.5';
                configBlock.style.pointerEvents = 'none';
                radios.forEach(r => r.disabled = true);
                input.disabled = true;
                card.classList.remove('border-blue-500', 'shadow-md');
                card.classList.add('border-gray-200', 'dark:border-gray-700');
                selectedBadge.style.display = 'none';
            }
            updateSelectedCount();
        }

        // Update active selection count
        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
            document.getElementById('selected-count').textContent = checkedCount;
        }

        // Update price after discount preview
        function updateDiscountPreview(productId) {
            const checkbox = document.querySelector(`.product-checkbox[value="${productId}"]`);
            if (!checkbox) return;
            const card = checkbox.closest('.product-card');
            const typeRadio = card.querySelector(`.discount-type-radio:checked`);
            const valueInput = card.querySelector(`.discount-value-input`);
            const previewSpan = card.querySelector(`.discount-preview-price`);

            const originalPrice = parseFloat(valueInput.getAttribute('data-original-price'));
            const discountType = typeRadio ? typeRadio.value : 'percent';
            const discountValue = parseFloat(valueInput.value) || 0;

            let finalPrice = originalPrice;
            if (discountType === 'percent') {
                finalPrice = originalPrice * (1 - discountValue / 100);
            } else { // nominal
                finalPrice = originalPrice - discountValue;
            }
            if (finalPrice < 0) finalPrice = 0;

            // Format as IDR
            previewSpan.textContent = "Rp " + Math.round(finalPrice).toLocaleString('id-ID');
        }

        // Select all visible products
        function selectAllVisibleProducts() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(checkbox) {
                const card = checkbox.closest('.product-card');
                if (card.style.display !== 'none') {
                    checkbox.checked = true;
                    toggleProductInputs(checkbox);
                }
            });
        }

        // Deselect all products
        function deselectAllProducts() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                toggleProductInputs(checkbox);
            });
        }

        const otherActiveCampaigns = @json($otherActiveCampaigns);

        function checkOverlappingProducts() {
            const startDateVal = document.getElementById('start_date').value;
            const endDateVal = document.getElementById('end_date').value;
            const statusVal = document.querySelector('input[name="status"]:checked').value;

            // Reset all cards first
            document.querySelectorAll('.product-card').forEach(function(card) {
                const checkbox = card.querySelector('.product-checkbox');
                checkbox.disabled = false;
                card.classList.remove('bg-gray-50', 'dark:bg-gray-700/30', 'opacity-60');
                card.querySelector('.overlap-warning').style.display = 'none';
                card.querySelector('.overlap-campaign-name').textContent = '';
            });

            if (statusVal !== 'aktif' || !startDateVal || !endDateVal) {
                return;
            }

            const formStart = new Date(startDateVal);
            const formEnd = new Date(endDateVal);

            if (isNaN(formStart.getTime()) || isNaN(formEnd.getTime())) {
                return;
            }

            otherActiveCampaigns.forEach(function(campaign) {
                const campStart = new Date(campaign.start_date);
                const campEnd = new Date(campaign.end_date);

                // Check overlap
                const isOverlapping = (campStart <= formEnd && campEnd >= formStart);

                if (isOverlapping) {
                    campaign.product_ids.forEach(function(prodId) {
                        const card = document.querySelector(`.product-card[data-product-id="${prodId}"]`);
                        if (card) {
                            const checkbox = card.querySelector('.product-checkbox');
                            
                            // If it was checked, uncheck it
                            if (checkbox.checked) {
                                checkbox.checked = false;
                                toggleProductInputs(checkbox);
                            }
                            
                            checkbox.disabled = true;
                            card.classList.add('bg-gray-50', 'dark:bg-gray-700/30', 'opacity-60');
                            
                            const warningDiv = card.querySelector('.overlap-warning');
                            warningDiv.style.display = 'block';
                            card.querySelector('.overlap-campaign-name').textContent = campaign.title;
                        }
                    });
                }
            });
        }
    </script>
@endsection
