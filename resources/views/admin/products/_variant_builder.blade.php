<div class="mb-6 rounded-sm border border-stroke bg-gray-50 p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="mb-4">
        <label class="flex cursor-pointer select-none items-center">
            <div class="relative">
                <input type="checkbox" id="has_variant" name="has_variant" class="sr-only" value="1" {{ old('has_variant', $product->has_variant ?? false) ? 'checked' : '' }} />
                <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-gray-700"></div>
                <div class="dot absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
            </div>
            <span class="ml-3 text-sm font-medium text-black dark:text-white">Produk ini memiliki varian (contoh: warna, tipe)</span>
        </label>
    </div>

    <div id="variant-builder-container" class="{{ old('has_variant', $product->has_variant ?? false) ? '' : 'hidden' }}">
        <input type="hidden" name="variant_options" id="variant_options_input" value="{{ old('variant_options', (isset($product) && $product->variant_options) ? json_encode($product->variant_options) : '[]') }}">
        
        <div class="mb-4 border border-stroke p-4 dark:border-gray-600 bg-white dark:bg-gray-700 rounded">
            <h4 class="mb-2 font-semibold text-black dark:text-white">Opsi Varian</h4>
            <div id="options-container" class="space-y-4">
                <!-- Options will be rendered here via JS -->
            </div>
            <button type="button" id="add-option-btn" class="mt-4 rounded bg-primary py-1 px-3 text-sm font-medium text-white hover:bg-opacity-90">
                + Tambah Opsi (Warna, Tipe, dll)
            </button>
        </div>

        <div class="mb-4">
            <h4 class="mb-2 font-semibold text-black dark:text-white">Daftar Varian</h4>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4 text-sm">
                            <th class="py-2 px-3 font-medium text-black dark:text-white">Varian</th>
                            <th class="py-2 px-3 font-medium text-black dark:text-white min-w-[120px]">Harga (Rp)</th>
                            <th class="py-2 px-3 font-medium text-black dark:text-white min-w-[80px]">Stok</th>
                            <th class="py-2 px-3 font-medium text-black dark:text-white min-w-[120px]">SKU</th>
                            <th class="py-2 px-3 font-medium text-black dark:text-white min-w-[120px]">Gambar</th>
                        </tr>
                    </thead>
                    <tbody id="variants-table-body">
                        <!-- Variants will be rendered here via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Toggle switch styles */
    input:checked ~ .dot { transform: translateX(100%); background-color: #3C50E0; }
    input:checked ~ .block { background-color: #E2E8F0; }
    .dark input:checked ~ .block { background-color: #1A222C; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasVariantCheckbox = document.getElementById('has_variant');
        const variantBuilderContainer = document.getElementById('variant-builder-container');
        const optionsContainer = document.getElementById('options-container');
        const addOptionBtn = document.getElementById('add-option-btn');
        const variantOptionsInput = document.getElementById('variant_options_input');
        const variantsTableBody = document.getElementById('variants-table-body');
        
        let options = JSON.parse(variantOptionsInput.value || '[]');
        let existingVariantsData = {};
        
        @if(isset($product) && $product->has_variant && $product->variants)
            @foreach($product->variants as $variant)
                existingVariantsData[{!! json_encode(is_array($variant->variant_combination) ? json_encode($variant->variant_combination) : $variant->variant_combination) !!}] = {
                    id: {{ $variant->id_variant }},
                    price: {!! json_encode($variant->harga_produk) !!},
                    stock: {!! json_encode($variant->stok_produk) !!},
                    sku: {!! json_encode($variant->sku_produk) !!},
                    img: {!! json_encode($variant->gambar_produk ? asset("storage/".$variant->gambar_produk) : "") !!}
                };
            @endforeach
        @endif

        let currentInputs = {};

        hasVariantCheckbox.addEventListener('change', function () {
            if (this.checked) {
                variantBuilderContainer.classList.remove('hidden');
                if (options.length === 0) { addOption(); }
            } else {
                variantBuilderContainer.classList.add('hidden');
            }
        });

        addOptionBtn.addEventListener('click', function() {
            if(options.length >= 3) { alert('Maksimal 3 opsi varian.'); return; }
            addOption();
        });

        function addOption(name = '', values = []) {
            options.push({ name: name, values: values });
            renderOptions();
        }

        window.focusInputIndex = null;

        function renderOptions() {
            optionsContainer.innerHTML = '';
            options.forEach((opt, index) => {
                const optDiv = document.createElement('div');
                optDiv.className = 'flex flex-col gap-3 p-4 border border-stroke dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-800';
                
                // Header & Option Name
                const headerDiv = document.createElement('div');
                headerDiv.className = 'flex flex-col md:flex-row md:items-start justify-between gap-4';
                
                const nameDiv = document.createElement('div');
                nameDiv.className = 'w-full md:w-1/2';
                nameDiv.innerHTML = `
                    <label class="mb-1 block text-sm font-medium text-black dark:text-white">Jenis Varian (contoh: Warna, Tipe, Ukuran)</label>
                    <input type="text" class="w-full rounded border-[1.5px] border-stroke bg-white py-2 px-3 text-sm text-black dark:text-white outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700" 
                           placeholder="Ketik jenis varian..." 
                           value="${opt.name}" data-index="${index}" oninput="updateOptionName(this)">
                `;
                
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'text-red-500 hover:text-red-700 text-sm font-medium mt-1 md:mt-7';
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt mr-1"></i> Hapus Grup Ini';
                deleteBtn.onclick = function() { removeOptionHandler(index); };

                headerDiv.appendChild(nameDiv);
                headerDiv.appendChild(deleteBtn);
                optDiv.appendChild(headerDiv);

                // Option Values
                const valuesWrapper = document.createElement('div');
                valuesWrapper.className = 'mt-2';
                valuesWrapper.innerHTML = `<label class="mb-1.5 block text-sm font-medium text-black dark:text-white">Pilihan (contoh: Merah, XL, dsb)</label>`;

                const inputGroup = document.createElement('div');
                inputGroup.className = 'flex gap-2 mb-3';
                
                const addValueInput = document.createElement('input');
                addValueInput.type = 'text';
                addValueInput.id = `add-value-input-${index}`;
                addValueInput.className = 'w-full md:w-1/2 rounded border-[1.5px] border-stroke bg-white py-2 px-3 text-sm text-black dark:text-white outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700';
                addValueInput.placeholder = 'Ketik pilihan lalu tekan Tambah...';
                
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90 transition';
                addBtn.innerText = 'Tambah';
                
                const handleAdd = () => {
                    if (addValueInput.value.trim() !== '') { 
                        window.focusInputIndex = index;
                        addOptionValue(index, addValueInput.value.trim()); 
                    }
                };

                addBtn.onclick = handleAdd;
                addValueInput.onkeydown = function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        handleAdd();
                    }
                };

                inputGroup.appendChild(addValueInput);
                inputGroup.appendChild(addBtn);
                valuesWrapper.appendChild(inputGroup);

                // Tags container
                const valuesDiv = document.createElement('div');
                valuesDiv.className = 'flex flex-wrap gap-2 mt-2';
                
                if (opt.values.length === 0) {
                    valuesDiv.innerHTML = '<span class="text-xs text-gray-500 italic">Belum ada pilihan yang ditambahkan.</span>';
                } else {
                    opt.values.forEach((val, vIndex) => {
                        const tag = document.createElement('span');
                        tag.className = 'inline-flex items-center gap-2 rounded-full border border-primary bg-primary/10 px-3 py-1.5 text-sm font-medium text-primary';
                        tag.innerHTML = `${val} <button type="button" class="hover:text-red-500 focus:outline-none" onclick="removeOptionValue(${index}, ${vIndex})"><i class="fas fa-times"></i></button>`;
                        valuesDiv.appendChild(tag);
                    });
                }
                
                valuesWrapper.appendChild(valuesDiv);
                optDiv.appendChild(valuesWrapper);
                optionsContainer.appendChild(optDiv);
            });

            updateHiddenInput();
            generateCombinations();

            // Restore focus if needed
            if (window.focusInputIndex !== null) {
                const inputToFocus = document.getElementById(`add-value-input-${window.focusInputIndex}`);
                if (inputToFocus) {
                    inputToFocus.focus();
                }
                window.focusInputIndex = null;
            }
        }

        window.updateOptionName = function(el) {
            const idx = el.getAttribute('data-index');
            options[idx].name = el.value;
            updateHiddenInput();
            generateCombinations();
        };

        window.removeOptionHandler = function(idx) {
            options.splice(idx, 1);
            renderOptions();
        };

        window.addOptionValue = function(idx, val) {
            if (!options[idx].values.includes(val)) {
                options[idx].values.push(val);
                renderOptions();
            }
        };

        window.removeOptionValue = function(oIdx, vIdx) {
            options[oIdx].values.splice(vIdx, 1);
            renderOptions();
        };

        function updateHiddenInput() {
            variantOptionsInput.value = JSON.stringify(options);
        }

        function generateCombinations() {
            saveCurrentInputs();
            variantsTableBody.innerHTML = '';
            
            const validOptions = options.filter(o => o.name.trim() !== '' && o.values.length > 0);
            if (validOptions.length === 0) return;

            let combos = [{}];
            validOptions.forEach(opt => {
                let temp = [];
                combos.forEach(combo => {
                    opt.values.forEach(val => {
                        let newCombo = { ...combo };
                        newCombo[opt.name] = val;
                        temp.push(newCombo);
                    });
                });
                combos = temp;
            });

            combos.forEach((combo, index) => {
                const comboStr = JSON.stringify(combo);
                const comboName = Object.values(combo).join(' - ');
                const saved = currentInputs[comboStr] || existingVariantsData[comboStr] || {};
                
                const idInput = saved.id ? `<input type="hidden" name="variants[${index}][id_variant]" value="${saved.id}">` : '';
                const imgPreview = saved.img ? `<img src="${saved.img}" class="h-10 w-10 object-cover rounded border border-gray-200 shadow-sm flex-shrink-0">` : '';

                const tr = document.createElement('tr');
                tr.className = "hover:bg-gray-50 transition-colors duration-150";
                tr.innerHTML = `
                    <td class="border-b border-[#eee] py-4 px-3 align-middle dark:border-strokedark">
                        ${idInput}
                        <input type="hidden" name="variants[${index}][variant_combination]" value='${comboStr}'>
                        <div class="font-medium text-gray-700 text-sm whitespace-nowrap">${comboName}</div>
                    </td>
                    <td class="border-b border-[#eee] py-4 px-3 align-middle dark:border-strokedark">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-xs font-medium">Rp</span>
                            </div>
                            <input type="number" name="variants[${index}][harga_produk]" class="w-full rounded-md border border-gray-300 bg-white py-1.5 pl-8 pr-3 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all dark:border-gray-500 dark:bg-gray-700 shadow-sm" value="${saved.price || ''}" required min="0" placeholder="0">
                        </div>
                    </td>
                    <td class="border-b border-[#eee] py-4 px-3 align-middle dark:border-strokedark">
                        <input type="number" name="variants[${index}][stok_produk]" class="w-full rounded-md border border-gray-300 bg-white py-1.5 px-3 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all dark:border-gray-500 dark:bg-gray-700 shadow-sm" value="${saved.stock || ''}" required min="0" placeholder="0">
                    </td>
                    <td class="border-b border-[#eee] py-4 px-3 align-middle dark:border-strokedark">
                        <input type="text" name="variants[${index}][sku_produk]" class="w-full rounded-md border border-gray-300 bg-white py-1.5 px-3 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all dark:border-gray-500 dark:bg-gray-700 shadow-sm" value="${saved.sku || ''}" placeholder="SKU (Opsional)">
                    </td>
                    <td class="border-b border-[#eee] py-4 px-3 align-middle dark:border-strokedark">
                        <div class="flex items-center gap-3">
                            ${imgPreview}
                            <input type="file" name="variants[${index}][gambar_produk]" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer transition-colors">
                        </div>
                    </td>
                `;
                variantsTableBody.appendChild(tr);
            });
        }

        function saveCurrentInputs() {
            const rows = variantsTableBody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const comboStr = row.querySelector(`input[name="variants[${index}][variant_combination]"]`)?.value;
                if (comboStr) {
                    currentInputs[comboStr] = {
                        id: row.querySelector(`input[name="variants[${index}][id_variant]"]`)?.value,
                        price: row.querySelector(`input[name="variants[${index}][harga_produk]"]`).value,
                        stock: row.querySelector(`input[name="variants[${index}][stok_produk]"]`).value,
                        sku: row.querySelector(`input[name="variants[${index}][sku_produk]"]`).value,
                        img: existingVariantsData[comboStr]?.img || ''
                    };
                }
            });
        }

        if (options.length > 0) {
            renderOptions();
        }
    });
</script>
