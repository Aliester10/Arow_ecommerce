@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <aside class="w-full md:w-1/4 lg:w-1/5 hidden md:block">
            @include('partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <!-- Breadcrumbs / Title -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">
                    @if(request('category'))
                        Kategori: {{ request('category') }}
                    @elseif(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @else
                        Semua Produk
                    @endif
                </h1>
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition group overflow-hidden">
                            <div class="relative h-48 bg-gray-100 overflow-hidden">
                                <!-- Product Image Placeholder -->
                                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                    <i class="fas fa-box text-4xl"></i>
                                </div>
                                
                                <!-- Overlay Actions -->
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <a href="{{ route('products.show', $product->id_produk) }}" class="p-2 bg-white rounded-full text-gray-800 hover:text-orange-600 mx-1 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 bg-orange-600 rounded-full text-white hover:bg-orange-700 mx-1 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">{{ $product->brand->nama_brand ?? 'Brand' }}</div>
                                <a href="{{ route('products.show', $product->id_produk) }}" class="block text-gray-800 font-medium text-sm mb-2 hover:text-orange-600 line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->nama_produk }}
                                </a>
                                <div class="font-bold text-orange-600">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-600">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 mt-2">Coba kata kunci lain atau reset filter.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">Lihat Semua Produk</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
