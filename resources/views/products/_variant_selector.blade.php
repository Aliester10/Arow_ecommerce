@if($product->has_variant && $product->variants->count() > 0 && $product->variant_options)
    <style>
        .variant-btn.active {
            border-color: #ee4d2d !important;
            color: #ee4d2d !important;
        }
        .variant-btn:hover:not(:disabled) {
            border-color: #ee4d2d !important;
            color: #ee4d2d !important;
        }
    </style>
    <div id="product-variants" class="mt-4 border-t border-gray-100 pt-4">
        @foreach($product->variant_options as $option)
            <div class="flex items-start mt-4 variant-option-group" data-option-name="{{ $option['name'] }}">
                <div class="w-[120px] text-gray-500 font-medium pt-1.5">{{ $option['name'] }}</div>
                <div class="flex-1 flex flex-wrap gap-2">
                    @foreach($option['values'] as $value)
                        <button type="button" 
                                class="variant-btn relative overflow-hidden px-3 py-1.5 border rounded-sm text-sm min-w-[60px] text-center transition-colors border-gray-300 text-gray-700 focus:outline-none"
                                data-value="{{ $value }}">
                            {{ $value }}
                            <div class="variant-check hidden absolute bottom-0 right-0">
                                <div style="width: 0; height: 0; border-bottom: 14px solid #ee4d2d; border-left: 14px solid transparent;"></div>
                                <svg class="absolute bottom-[1px] right-[1px]" style="width: 10px; height: 10px; color: white;" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="2 5 4 7 8 2"></polyline>
                                </svg>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productVariants = {!! json_encode($product->variants->map(function($v) {
                return [
                    'id' => $v->id_variant,
                    'combination' => is_array($v->variant_combination) ? $v->variant_combination : json_decode($v->variant_combination, true),
                    'price' => $v->harga_produk,
                    'price_formatted' => 'Rp ' . number_format($v->harga_produk, 0, ',', '.'),
                    'stock' => $v->stok_produk,
                    'image' => $v->gambar_produk ? asset('storage/'.$v->gambar_produk) : null,
                ];
            })) !!};

            let selectedOptions = {};
            const optionGroups = document.querySelectorAll('.variant-option-group');
            const addToCartForm = document.getElementById('addToCartForm');
            
            // Add hidden input for selected variant ID to the form
            let hiddenVariantInput = document.getElementById('selectedVariantId');
            if (!hiddenVariantInput && addToCartForm) {
                hiddenVariantInput = document.createElement('input');
                hiddenVariantInput.type = 'hidden';
                hiddenVariantInput.name = 'id_variant';
                hiddenVariantInput.id = 'selectedVariantId';
                addToCartForm.appendChild(hiddenVariantInput);
            }

            // Price and stock elements
            const priceElement = document.querySelector('.text-2xl.md\\:text-3xl.font-medium.text-\\[\\#ee4d2d\\]');
            const stockElement = document.querySelector('.text-gray-500.tersisa-text'); // I will add a class to the stock text later
            const qtyInput = document.getElementById('quantity');

            // Find stock element containing 'Tersisa'
            let stockElm = null;
            document.querySelectorAll('.text-gray-500').forEach(el => {
                if (el.textContent.includes('Tersisa')) stockElm = el;
            });

            optionGroups.forEach(group => {
                const optName = group.getAttribute('data-option-name');
                const buttons = group.querySelectorAll('.variant-btn');

                buttons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (this.disabled) return;
                        
                        const val = this.getAttribute('data-value');
                        
                        // Toggle selection
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                            this.querySelector('.variant-check').classList.add('hidden');
                            delete selectedOptions[optName];
                        } else {
                            // Deselect others in group
                            buttons.forEach(b => {
                                b.classList.remove('active');
                                b.querySelector('.variant-check').classList.add('hidden');
                            });
                            this.classList.add('active');
                            this.querySelector('.variant-check').classList.remove('hidden');
                            selectedOptions[optName] = val;
                        }

                        checkVariantCombination();
                    });
                });
            });

            function checkVariantCombination() {
                // Determine available options based on current selection
                optionGroups.forEach(group => {
                    const optName = group.getAttribute('data-option-name');
                    const buttons = group.querySelectorAll('.variant-btn');

                    buttons.forEach(btn => {
                        const val = btn.getAttribute('data-value');
                        
                        if (selectedOptions[optName] === val) {
                            btn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
                            btn.disabled = false;
                            return;
                        }

                        let tempSelected = { ...selectedOptions, [optName]: val };
                        
                        const possibleCombos = productVariants.filter(v => {
                            for(const key in tempSelected) {
                                if(v.combination[key] !== tempSelected[key]) return false;
                            }
                            return v.stock > 0;
                        });

                        if (possibleCombos.length === 0) {
                            btn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
                            btn.disabled = true;
                        } else {
                            btn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
                            btn.disabled = false;
                        }
                    });
                });

                // Check if all options are selected
                if (Object.keys(selectedOptions).length === optionGroups.length) {
                    // Find the matching variant
                    const matchedVariant = productVariants.find(v => {
                        let match = true;
                        for (const key in selectedOptions) {
                            if (v.combination[key] !== selectedOptions[key]) {
                                match = false;
                                break;
                            }
                        }
                        return match;
                    });

                    if (matchedVariant) {
                        // Update Price
                        if (priceElement) {
                            // This might need adjustments if there's discount
                            priceElement.innerText = matchedVariant.price_formatted;
                        }

                        // Update Stock
                        if (stockElm) {
                            stockElm.innerText = 'Tersisa ' + matchedVariant.stock + ' Buah';
                        }
                        if (qtyInput) {
                            qtyInput.max = matchedVariant.stock;
                            if (parseInt(qtyInput.value) > matchedVariant.stock) {
                                qtyInput.value = matchedVariant.stock > 0 ? 1 : 0;
                            }
                        }

                        // Update Image
                        if (matchedVariant.image) {
                            const mainImage = document.getElementById('mainProductImage');
                            if (mainImage) mainImage.src = matchedVariant.image;
                        }

                        // Update hidden input
                        if (hiddenVariantInput) {
                            hiddenVariantInput.value = matchedVariant.id;
                        }

                        // Disable add to cart if out of stock
                        const submitBtns = addToCartForm ? addToCartForm.querySelectorAll('button[type="submit"]') : [];
                        submitBtns.forEach(btn => {
                            if (matchedVariant.stock <= 0) {
                                btn.disabled = true;
                                btn.classList.add('opacity-50', 'cursor-not-allowed');
                            } else {
                                btn.disabled = false;
                                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        });

                    }
                } else {
                    if (hiddenVariantInput) hiddenVariantInput.value = '';
                }
            }
            
            // Initialize cross-checking on load
            checkVariantCombination();

            // Validate before submitting form
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    if (optionGroups.length > 0 && (!hiddenVariantInput || !hiddenVariantInput.value)) {
                        e.preventDefault();
                        alert('Silakan pilih varian produk terlebih dahulu.');
                    }
                });
            }
        });
    </script>
@endif
