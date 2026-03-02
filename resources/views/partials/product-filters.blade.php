<div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 mt-4 md:mt-6">
    {{-- Header --}}
    <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-100 rounded-t-lg sm:rounded-t-xl" style="background-color:#F7931E">
        <div class="flex items-center text-white font-semibold text-xs sm:text-sm gap-2">
            <i class="fas fa-filter text-sm"></i>
            <span>Filter Produk</span>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="p-3 sm:p-4 space-y-4">
        {{-- Preserve existing query parameters --}}
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        {{-- Brand Filter --}}
        <div>
            <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i class="fas fa-tag text-orange-500"></i>
                BRAND
            </h3>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                @forelse($brands as $brand)
                    <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded transition-colors">
                        <input type="checkbox" 
                               name="brands[]" 
                               value="{{ $brand->id_brand }}"
                               @if(in_array($brand->id_brand, request('brands', []))) checked @endif
                               class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                        <span class="text-xs sm:text-sm text-gray-700">{{ $brand->nama_brand }}</span>
                    </label>
                @empty
                    <p class="text-xs text-gray-500 italic">Tidak ada brand tersedia</p>
                @endforelse
            </div>
        </div>

        {{-- Price Range Filter --}}
        <div>
            <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-orange-500"></i>
                HARGA
            </h3>
            <div class="space-y-3">
                <div>
                    <label for="min_price" class="block text-xs text-gray-600 mb-1">Minimum</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                        <input type="text" 
                               id="min_price"
                               name="min_price" 
                               value="{{ request('min_price') }}"
                               placeholder="Harga minimum"
                               class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
                <div>
                    <label for="max_price" class="block text-xs text-gray-600 mb-1">Maksimum</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                        <input type="text" 
                               id="max_price"
                               name="max_price" 
                               value="{{ request('max_price') }}"
                               placeholder="Harga maksimum"
                               class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit" 
                    class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors duration-200 font-medium text-sm flex items-center justify-center gap-2">
                <i class="fas fa-check"></i>
                Submit
            </button>
        </div>

        {{-- Clear Filters --}}
        @if(request()->hasAny(['brands', 'min_price', 'max_price']))
            <div class="pt-1">
                <a href="{{ request()->url() }}?{{ http_build_query(request()->only(['search', 'category'])) }}" 
                   class="w-full block text-center text-gray-600 hover:text-orange-600 py-2 px-4 rounded-lg border border-gray-300 hover:border-orange-500 transition-colors duration-200 text-sm">
                    <i class="fas fa-times mr-1"></i>
                    Reset Filter
                </a>
            </div>
        @endif
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format price inputs to Indonesian format
    const priceInputs = document.querySelectorAll('input[name="min_price"], input[name="max_price"]');
    
    priceInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
                e.target.value = value;
            } else {
                e.target.value = '';
            }
        });

        // Format on load
        if (input.value) {
            let value = input.value.replace(/[^\d]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('id-ID');
                input.value = value;
            }
        }
    });
});
</script>
