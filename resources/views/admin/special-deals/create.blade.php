@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Tambah Special Deal
        </h2>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        <form action="{{ route('admin.special-deals.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Judul Section
                    </label>
                    <input type="text" name="title" value="Special Deals" required
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <div>
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                        Subtitle
                    </label>
                    <input type="text" name="subtitle" placeholder="Contoh: For This Year"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>
            </div>

            <div class="mt-6">
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    <input type="checkbox" name="is_active" checked class="mr-2">
                    Aktif
                </label>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Produk dan Diskon</h3>
                
                <!-- Search Input -->
                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                        Cari Produk
                    </label>
                    <input type="text" id="product-search" placeholder="Ketik nama produk untuk mencari..."
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                </div>

                <!-- Products Checkbox List -->
                <div class="mb-4">
                    <div class="border rounded-lg p-4 max-h-96 overflow-y-auto">
                        <div id="products-checkbox-list">
                            @foreach($products as $product)
                                <div class="product-checkbox-item mb-3 p-3 border rounded hover:bg-gray-50 dark:hover:bg-gray-700" data-product-name="{{ strtolower($product->nama_produk) }}">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="selected_products[]" value="{{ $product->id_produk }}" 
                                            class="mr-3 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <div class="flex-1">
                                            <div class="font-medium text-black dark:text-white">{{ $product->nama_produk }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Rp. {{ number_format($product->harga_produk, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        <div id="no-products-found" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
                            Tidak ada produk yang ditemukan
                        </div>
                    </div>
                </div>

                <!-- Discount Percentage Input -->
                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                        Persentase Diskon (%)
                    </label>
                    <input type="number" name="discount_percentage" min="1" max="100" required
                        placeholder="Masukkan persentase diskon untuk semua produk yang dipilih"
                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-primary">
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Diskon ini akan diterapkan ke semua produk yang Anda centang di atas
                    </p>
                </div>

                <!-- Selected Products Summary -->
                <div class="mb-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                Produk yang dipilih: <span id="selected-count">0</span>
                            </span>
                            <button type="button" onclick="selectAllProducts()" 
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                Pilih Semua
                            </button>
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
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Real-time search functionality
        document.getElementById('product-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-checkbox-item');
            const noProductsFound = document.getElementById('no-products-found');
            let visibleCount = 0;

            productItems.forEach(function(item) {
                const productName = item.getAttribute('data-product-name');
                if (productName.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide "no products found" message
            if (visibleCount === 0 && searchTerm !== '') {
                noProductsFound.classList.remove('hidden');
            } else {
                noProductsFound.classList.add('hidden');
            }
        });

        // Update selected count when checkboxes change
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
            const selectedCount = document.getElementById('selected-count');
            selectedCount.textContent = checkboxes.length;
        }

        // Add event listeners to all checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSelectedCount);
            });
            
            // Initialize count
            updateSelectedCount();
        });

        // Select all products functionality
        function selectAllProducts() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            const visibleCheckboxes = Array.from(checkboxes).filter(function(checkbox) {
                const item = checkbox.closest('.product-checkbox-item');
                return item.style.display !== 'none';
            });

            const allChecked = visibleCheckboxes.every(function(checkbox) {
                return checkbox.checked;
            });

            visibleCheckboxes.forEach(function(checkbox) {
                checkbox.checked = !allChecked;
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
