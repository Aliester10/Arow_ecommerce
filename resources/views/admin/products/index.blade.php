@extends('layouts.admin')



@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Daftar Produk
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Total: {{ $products->total() }} produk
            </p>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('admin.products.import') }}"
                class="inline-flex items-center justify-center rounded-md bg-green-600 py-4 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
                <i class="fas fa-file-excel mr-2"></i> Import Excel
            </a>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <i class="fas fa-plus mr-2"></i> Tambah Produk
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') ?? $search ?? '' }}" 
                           placeholder="Cari produk berdasarkan nama atau merk..." 
                           class="w-full rounded-md border border-stroke dark:border-gray-700 dark:bg-gray-800 py-3 px-4 pl-12 text-gray-800 dark:text-white focus:outline-none focus:ring focus:border-blue-300">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <button type="submit" 
                    class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90 transition-colors">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center justify-center rounded-md bg-gray-500 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90 transition-colors">
                    <i class="fas fa-times mr-2"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        @if(session('success'))
            <div
                class="flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
                <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399]">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3068 6.91894 10.979L15.2925 1.97485C15.6257 1.6091 15.6269 1.04057 15.2984 0.826822Z"
                            fill="white" stroke="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">
                        Sukses
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-gray-700">
                        <th class="min-w-[50px] py-4 px-4 font-medium text-black dark:text-white text-center">
                            <input type="checkbox" id="selectAll" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </th>
                        <th class="min-w-[50px] py-4 px-4 font-medium text-black dark:text-white text-center">
                            No
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            Gambar
                        </th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                            Nama Produk
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Kategori
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Stok
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                <input type="checkbox" name="selected_products[]" value="{{ $product->id_produk }}" class="product-checkbox form-checkbox h-4 w-4 text-blue-600 rounded">
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <div style="width: 80px; height: 80px;"
                                    class="rounded-md overflow-hidden flex items-center justify-center bg-gray-50 dark:bg-gray-700 border border-stroke dark:border-gray-600 flex-shrink-0">
                                    @if($product->firstImage || $product->gambar_produk)
                                        <img style="width: 80px; height: 80px; object-fit: cover;"
                                            src="{{ $product->firstImage ? $product->firstImage->url : asset('storage/images/produk/' . $product->gambar_produk) }}"
                                            alt="{{ $product->nama_produk }}" />
                                    @else
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <h5 class="font-medium text-black dark:text-white">{{ $product->nama_produk }}</h5>
                                <p class="text-sm">{{ $product->brand->nama_brand ?? '-' }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">
                                    {{ $product->subSubkategori->nama_sub_subkategori ?? ($product->subkategori->nama_subkategori ?? ($product->kategori->nama_kategori ?? '-')) }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $product->stok_produk }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p
                                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $product->status_produk == 'aktif' ? 'bg-success text-success' : 'bg-danger text-danger' }}">
                                    {{ $product->status_produk }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('admin.products.edit', $product->id_produk) }}"
                                        class="hover:text-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada produk ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions Section -->
        <div id="bulkActions" class="hidden mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-gray-300 font-medium">
                        <span id="selectedCount">0</span> produk dipilih
                    </span>
                    <div class="flex items-center space-x-2">
                        <button onclick="bulkDelete()" 
                                class="inline-flex items-center justify-center rounded-md bg-red-600 py-2 px-4 text-center font-medium text-white hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                        <button onclick="bulkUpdateStatus('aktif')" 
                                class="inline-flex items-center justify-center rounded-md bg-green-600 py-2 px-4 text-center font-medium text-white hover:bg-green-700 transition-colors">
                            <i class="fas fa-check mr-2"></i> Aktifkan
                        </button>
                        <button onclick="bulkUpdateStatus('nonaktif')" 
                                class="inline-flex items-center justify-center rounded-md bg-yellow-600 py-2 px-4 text-center font-medium text-white hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-times mr-2"></i> Nonaktifkan
                        </button>
                        <button onclick="clearSelection()" 
                                class="inline-flex items-center justify-center rounded-md bg-gray-500 py-2 px-4 text-center font-medium text-white hover:bg-gray-600 transition-colors">
                            <i class="fas fa-times mr-2"></i> Batal Pilih
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="flex items-center space-x-4">
                    <label for="perPage" class="text-gray-600 dark:text-gray-400 whitespace-nowrap">Tampilkan</label>
                    <select id="perPage" onchange="window.location.href = this.value" class="rounded-md border border-stroke dark:border-gray-700 dark:bg-gray-800 py-2 px-3 text-gray-800 dark:text-white focus:outline-none focus:ring focus:border-blue-300">
                        @foreach ([10, 20, 30, 40, 50] as $perPageOption)
                            <option value="{{ request()->url() }}?page=1&per_page={{ $perPageOption }}@if(request('search'))&search={{ request('search') }}@endif" {{ request('per_page', 10) == $perPageOption ? 'selected' : '' }}>
                                {{ $perPageOption }} Data
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    @if($products->total() > 0)
                        Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} data
                    @else
                        Tidak ada data
                    @endif
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                {{-- Previous button --}}
                @if($products->onFirstPage())
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-md border border-gray-300 dark:border-gray-600">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}&per_page={{ request('per_page', 10) }}@if(request('search'))&search={{ request('search') }}@endif" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif
                
                {{-- Page numbers --}}
                @php
                    $currentPage = $products->currentPage();
                    $lastPage = $products->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                    
                    if ($start > 1) {
                        $showFirst = true;
                    }
                    if ($end < $lastPage) {
                        $showLast = true;
                    }
                @endphp
                
                {{-- First page --}}
                @if($start > 1)
                    <a href="{{ $products->url(1) }}&per_page={{ request('per_page', 10) }}@if(request('search'))&search={{ request('search') }}@endif" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 transition-colors">
                        1
                    </a>
                    @if($start > 2)
                        <span class="px-3 py-2 text-gray-600 dark:text-gray-400">...</span>
                    @endif
                @endif
                
                {{-- Page range --}}
                @for($i = $start; $i <= $end; $i++)
                    @if($i == $currentPage)
                        <span class="px-3 py-2 bg-primary text-white rounded-md border border-primary">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $products->url($i) }}&per_page={{ request('per_page', 10) }}@if(request('search'))&search={{ request('search') }}@endif" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 transition-colors">
                            {{ $i }}
                        </a>
                    @endif
                @endfor
                
                {{-- Last page --}}
                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="px-3 py-2 text-gray-600 dark:text-gray-400">...</span>
                    @endif
                    <a href="{{ $products->url($lastPage) }}&per_page={{ request('per_page', 10) }}@if(request('search'))&search={{ request('search') }}@endif" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 transition-colors">
                        {{ $lastPage }}
                    </a>
                @endif
                
                {{-- Next button --}}
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}&per_page={{ request('per_page', 10) }}@if(request('search'))&search={{ request('search') }}@endif" class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-3 py-2 text-gray-400 cursor-not-allowed rounded-md border border-gray-300 dark:border-gray-600">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });

        // Individual checkbox change
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllCheckbox();
                toggleBulkActions();
            });
        });

        // Update select all checkbox based on individual checkboxes
        function updateSelectAllCheckbox() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedBoxes.length === checkboxes.length) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }
        }

        // Toggle bulk actions visibility
        function toggleBulkActions() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (checkedBoxes.length > 0) {
                bulkActions.classList.remove('hidden');
                selectedCount.textContent = checkedBoxes.length;
            } else {
                bulkActions.classList.add('hidden');
                selectedCount.textContent = '0';
            }
        }

        // Clear selection function
        function clearSelection() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
            
            toggleBulkActions();
        }

        // Get selected product IDs
        function getSelectedProducts() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        // Bulk delete function
        function bulkDelete() {
            const selectedProducts = getSelectedProducts();
            
            console.log('Selected products:', selectedProducts);
            
            if (selectedProducts.length === 0) {
                alert('Pilih setidaknya satu produk untuk dihapus!');
                return;
            }

            if (confirm(`Apakah Anda yakin ingin menghapus ${selectedProducts.length} produk yang dipilih?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.products.bulkDelete") }}';
                
                console.log('Form action:', form.action);
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add selected products
                selectedProducts.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_products[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Bulk update status function
        function bulkUpdateStatus(status) {
            const selectedProducts = getSelectedProducts();
            
            if (selectedProducts.length === 0) {
                alert('Pilih setidaknya satu produk untuk diperbarui!');
                return;
            }

            const statusText = status === 'aktif' ? 'mengaktifkan' : 'menonaktifkan';
            if (confirm(`Apakah Anda yakin ingin ${statusText} ${selectedProducts.length} produk yang dipilih?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.products.bulkUpdateStatus") }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add status
                const statusField = document.createElement('input');
                statusField.type = 'hidden';
                statusField.name = 'status';
                statusField.value = status;
                form.appendChild(statusField);
                
                // Add selected products
                selectedProducts.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_products[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection