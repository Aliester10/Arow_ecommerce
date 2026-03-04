{{-- Live Preview Card for Product Create/Edit --}}
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark flex justify-between items-center">
        <h3 class="font-medium text-black dark:text-white">
            <i class="fas fa-eye mr-2 text-primary"></i> Live Preview
        </h3>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            *Preview berubah saat Anda mengetik
        </span>
    </div>
    <div class="p-6">
        {{-- Preview mimics the frontend product detail layout --}}
        <div
            class="bg-white dark:bg-boxdark-2 rounded-xl border border-gray-200 dark:border-strokedark overflow-hidden shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 p-5">
                {{-- Left: Image Preview --}}
                <div>
                    <div
                        class="aspect-square bg-gray-100 dark:bg-meta-4 rounded-lg overflow-hidden border border-gray-200 dark:border-strokedark relative">
                        {{-- Product Image (z-10) --}}
                        <div id="previewImageContainer" class="absolute inset-0 flex items-center justify-center"
                            style="z-index: 10;">
                            @if(isset($product) && ($product->firstImage || $product->gambar_produk))
                                <img id="previewImage" src="{{ $product->image_url }}" alt="Preview"
                                    class="object-contain w-full h-full"
                                    style="transform: scale(0.75); transform-origin: center;">
                            @else
                                <img id="previewImage" src="" alt="Preview" class="object-contain w-full h-full hidden"
                                    style="transform: scale(0.75); transform-origin: center;">
                                <div id="previewImagePlaceholder" class="text-center">
                                    <i class="fas fa-image text-5xl text-gray-300 dark:text-gray-500"></i>
                                    <p class="text-xs text-gray-400 mt-2">Pilih gambar untuk preview</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right: Product Info Preview --}}
                <div class="flex flex-col">
                    {{-- Breadcrumb mock --}}
                    <nav class="flex text-xs text-gray-400 mb-3">
                        <span>Home</span>
                        <i class="fas fa-chevron-right text-[8px] mx-1.5 mt-0.5"></i>
                        <span id="previewCategory" class="text-gray-500">Kategori</span>
                        <i class="fas fa-chevron-right text-[8px] mx-1.5 mt-0.5"></i>
                        <span class="text-gray-400 truncate max-w-[100px]" id="previewBreadcrumbName">Nama Produk</span>
                    </nav>

                    {{-- Product Name --}}
                    <h1 id="previewName" class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ isset($product) ? $product->nama_produk : 'Nama Produk' }}
                    </h1>

                    {{-- Brand & Rating --}}
                    <div class="flex items-center mb-3 space-x-3 text-xs">
                        <div
                            class="text-gray-500 dark:text-gray-400 border-r border-gray-300 dark:border-strokedark pr-3">
                            Brand: <span id="previewBrand"
                                class="text-orange-600 font-medium">{{ isset($product) && $product->brand ? $product->brand->nama_brand : 'Brand' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <span class="text-gray-600 dark:text-gray-400 ml-1 font-bold">4.8</span>
                            <span class="text-gray-400 ml-1">(12 Ulasan)</span>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <span id="previewPrice" class="text-xl font-bold text-orange-600">
                            {{ isset($product) && $product->harga_produk ? 'Rp ' . number_format($product->harga_produk, 0, ',', '.') : 'Rp 0' }}
                        </span>
                    </div>



                    {{-- Stock & Weight --}}
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <div>Stok: <span id="previewStock"
                                class="font-medium text-gray-800 dark:text-white">{{ isset($product) ? $product->stok_produk : '0' }}</span>
                        </div>
                        <div>Berat: <span id="previewWeight"
                                class="font-medium text-gray-800 dark:text-white">{{ isset($product) ? $product->berat_produk : '0' }}</span>
                            gr</div>
                    </div>

                    {{-- Action Buttons (mock) --}}
                    <div class="flex space-x-2 mt-auto">
                        <button type="button"
                            class="flex-1 px-3 py-2 border border-orange-600 text-orange-600 text-xs font-bold rounded-lg cursor-default">
                            <i class="far fa-heart mr-1"></i> Favorit
                        </button>
                        <button type="button"
                            class="flex-1 px-3 py-2 bg-orange-600 text-white text-xs font-bold rounded-lg cursor-default">
                            <i class="fas fa-plus mr-1"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>

            {{-- Spec Table Preview --}}
            <div class="border-t border-gray-100 dark:border-strokedark -mx-5 px-5 lg:mx-0 lg:px-0">
                <div class="flex border-b border-gray-100 dark:border-strokedark">
                    <button type="button"
                        class="flex-1 px-4 py-3 text-sm font-semibold text-orange-600 border-b-2 border-orange-600 bg-orange-50 dark:bg-meta-4">
                        Detail Produk
                    </button>
                    <!-- Space to mimic the review tab placement -->
                    <div class="flex-1"></div>
                </div>
                <div class="p-4">
                    <dl class="text-xs divide-y divide-gray-100 dark:divide-strokedark">
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowName">
                            <dt class="text-gray-500 dark:text-gray-400">Nama Produk</dt>
                            <dd id="previewSpecName" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) ? $product->nama_produk : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowType">
                            <dt class="text-gray-500 dark:text-gray-400">Tipe Produk</dt>
                            <dd id="previewSpecType" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) ? ($product->tipe_produk ?? '-') : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowDimension">
                            <dt class="text-gray-500 dark:text-gray-400">Dimensi</dt>
                            <dd id="previewSpecDimension" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) ? ($product->dimensi_produk ?? '-') : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowDeskripsi"
                            style="display: {{ isset($product) && $product->deskripsi_produk ? 'grid' : 'none' }};">
                            <dt class="text-gray-500 dark:text-gray-400">Spesifikasi</dt>
                            <dd id="previewDesc"
                                class="col-span-2 font-medium text-gray-800 dark:text-white whitespace-pre-line">
                                {{ isset($product) ? $product->deskripsi_produk : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowBrand">
                            <dt class="text-gray-500 dark:text-gray-400">Merek</dt>
                            <dd id="previewSpecBrand" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) && $product->brand ? $product->brand->nama_brand : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowSKU">
                            <dt class="text-gray-500 dark:text-gray-400">SKU</dt>
                            <dd id="previewSpecSKU" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) ? ($product->sku_produk ?? '-') : '-' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-2" id="rowOrigin">
                            <dt class="text-gray-500 dark:text-gray-400">Asal Negara</dt>
                            <dd id="previewSpecOrigin" class="col-span-2 font-medium text-gray-800 dark:text-white">
                                {{ isset($product) ? ($product->asal_produk ?? '-') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Format number to IDR currency
        function formatRupiah(num) {
            if (!num || isNaN(num)) return 'Rp 0';
            return 'Rp ' + parseInt(num).toLocaleString('id-ID');
        }

        const textMappings = {
            'nama_produk': ['previewName', 'previewSpecName', 'previewBreadcrumbName'],
            'sku_produk': ['previewSpecSKU'],
            'tipe_produk': ['previewSpecType'],
            'asal_produk': ['previewSpecOrigin'],
            'dimensi_produk': ['previewSpecDimension'],
            'spesifikasi_produk': ['previewSpecSpesifikasi'],
            'deskripsi_produk': ['previewDesc'],
            'stok_produk': ['previewStock'],
            'berat_produk': ['previewWeight'],
        };

        // Attach input listeners for text fields
        Object.keys(textMappings).forEach(function (fieldName) {
            const input = document.querySelector('[name="' + fieldName + '"]');
            if (input) {
                input.addEventListener('input', function () {
                    const val = this.value || '-';
                    textMappings[fieldName].forEach(function (elId) {
                        const el = document.getElementById(elId);
                        if (el) el.textContent = val;
                    });
                });
            }
        });

        // Conditionally hide empty rows for Spesifikasi & Deskripsi
        function setupConditionalRow(inputName, rowId) {
            const input = document.querySelector(`[name="${inputName}"]`);
            const row = document.getElementById(rowId);
            if (input && row) {
                const updateRow = () => {
                    const val = input.value.trim();
                    row.style.display = val ? 'grid' : 'none';
                };
                input.addEventListener('input', updateRow);
                // Also trigger initially but wait a bit to ensure it processes if pre-filled
                setTimeout(updateRow, 100);
            }
        }

        setupConditionalRow('spesifikasi_produk', 'rowSpesifikasi');
        setupConditionalRow('deskripsi_produk', 'rowDeskripsi');

        // Price field - special formatting
        const priceInput = document.querySelector('[name="harga_produk"]');
        if (priceInput) {
            priceInput.addEventListener('input', function () {
                const el = document.getElementById('previewPrice');
                if (el) el.textContent = formatRupiah(this.value);
            });
        }

        // Brand select
        const brandSelect = document.querySelector('[name="id_brand"]');
        if (brandSelect) {
            brandSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const brandName = selectedOption && selectedOption.value ? selectedOption.textContent.trim() : 'Brand';

                const brandEl = document.getElementById('previewBrand');
                const specBrandEl = document.getElementById('previewSpecBrand');
                if (brandEl) brandEl.textContent = brandName;
                if (specBrandEl) specBrandEl.textContent = brandName;
            });
        }

        // Category select
        const categorySelect = document.querySelector('[name="id_sub_subkategori"]');
        if (categorySelect) {
            categorySelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const catName = selectedOption && selectedOption.value ? selectedOption.textContent.trim() : 'Kategori';

                const catEl = document.getElementById('previewCategory');
                if (catEl) catEl.textContent = catName;
            });
        }

        // Image file preview using FileReader
        const imageInput = document.querySelector('[name="gambar_produk"]');
        if (imageInput) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const previewImg = document.getElementById('previewImage');
                        const placeholder = document.getElementById('previewImagePlaceholder');

                        if (previewImg) {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('hidden');
                        }
                        if (placeholder) {
                            placeholder.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>