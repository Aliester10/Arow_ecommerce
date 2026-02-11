@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
                    <!-- Main Image Placeholder -->
                    <i class="fas fa-box text-6xl text-gray-300"></i>
                </div>
                <!-- Thumbnails (Static for now) -->
                <div class="grid grid-cols-4 gap-2">
                    @for($i=0; $i<4; $i++)
                        <div class="aspect-square bg-gray-50 rounded-md border border-gray-200 cursor-pointer hover:border-orange-500 transition flex items-center justify-center">
                            <i class="fas fa-image text-gray-300"></i>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <nav class="flex text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="hover:text-orange-600">Home</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-xs mx-2"></i>
                                <a href="{{ route('products.index', ['category' => $product->subkategori->kategori->nama_kategori ?? 'All']) }}" class="hover:text-orange-600">{{ $product->subkategori->kategori->nama_kategori ?? 'Kategori' }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-xs mx-2"></i>
                                <span class="text-gray-400">{{ Str::limit($product->nama_produk, 20) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->nama_produk }}</h1>
                
                <div class="flex items-center mb-4 space-x-4">
                    <div class="text-sm text-gray-500 border-r border-gray-300 pr-4">
                        Brand: <span class="text-orange-600 font-medium">{{ $product->brand->nama_brand ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <span class="text-sm text-gray-600 ml-1 font-bold">4.8</span>
                        <span class="text-sm text-gray-400 ml-1">(12 Ulasan)</span>
                    </div>
                </div>

                <div class="text-3xl font-bold text-orange-600 mb-6">
                    Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $product->deskripsi_produk }}
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <form action="{{ route('cart.add', $product->id_produk) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100" onclick="decrementQty()">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stok_produk }}" class="w-12 text-center text-sm focus:outline-none" readonly>
                                <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100" onclick="incrementQty()">+</button>
                            </div>
                            <div class="text-sm text-gray-500">
                                Stok: <span class="font-medium">{{ $product->stok_produk }}</span>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button" class="flex-1 px-6 py-3 border border-orange-600 text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition">
                                Beli Langsung
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i> Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Produk Terkait</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                     <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition">
                        <div class="h-32 bg-gray-100 rounded-md mb-3 flex items-center justify-center">
                            <i class="fas fa-box text-2xl text-gray-300"></i>
                        </div>
                        <a href="{{ route('products.show', $related->id_produk) }}" class="block text-sm font-medium text-gray-800 mb-1 hover:text-orange-600 line-clamp-2">
                            {{ $related->nama_produk }}
                        </a>
                        <div class="text-orange-600 font-bold text-sm">
                            Rp {{ number_format($related->harga_produk, 0, ',', '.') }}
                        </div>
                     </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        let val = parseInt(input.value);
        if (val < max) {
            input.value = val + 1;
        }
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        let val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
        }
    }
</script>
@endsection
