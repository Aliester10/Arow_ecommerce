@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 768px) {
            .products-row-layout {
                --sidebar-width: 30%;
            }

            .products-row-layout .products-sidebar {
                flex: 0 0 var(--sidebar-width);
                max-width: var(--sidebar-width);
            }

            .products-row-layout .products-content {
                flex: 1 1 0;
                min-width: 0;
            }
        }
    </style>
    <div class="container mx-auto px-2 sm:px-4">
        <div class="products-row-layout flex flex-col md:flex-row gap-4 md:gap-6 relative"
            style="--sidebar-width: 30%; --sidebar-gap: 1.5rem;">
            <!-- Sidebar -->
            <aside class="products-sidebar w-full hidden md:block">
                @include('partials.sidebar')
            </aside>

            <!-- Main Content -->
            <div class="products-content w-full">
                <!-- Breadcrumbs / Title -->
                <div class="mb-4 md:mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <h1 class="text-lg sm:text-xl font-bold text-gray-800">
                        @if(request('category'))
                            Kategori: {{ request('category') }}
                        @elseif(request('search'))
                            Hasil Pencarian: "{{ request('search') }}"
                        @else
                            Semua Produk
                        @endif
                    </h1>
                    <div class="text-xs sm:text-sm text-gray-500">
                        Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari
                        {{ $products->total() }} produk
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4 md:gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden"
                                data-skeleton-container>
                                <div class="relative aspect-[4/3] bg-white overflow-hidden">
                                    <!-- Skeleton Loading (z-30) -->
                                    <div data-skeleton
                                        class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0" style="z-index: 30;">
                                    </div>

                                    <!-- Product Image (z-10) -->
                                    @php
                                        $imagePath = null;
                                        if ($product->gambar_produk) {
                                            $path1 = 'storage/images/produk/' . $product->gambar_produk;
                                            $path2 = 'storage/images/produk/' . str_replace(' ', '', $product->gambar_produk);
                                            $path3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $product->gambar_produk));
                                            
                                            if (file_exists(public_path($path1))) $imagePath = $path1;
                                            elseif (file_exists(public_path($path2))) $imagePath = $path2;
                                            elseif (file_exists(public_path($path3))) $imagePath = $path3;
                                        }
                                    @endphp

                                    @if($imagePath)
                                        <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $product->nama_produk }}" data-skeleton-image
                                                class="object-contain w-full h-full"
                                                style="transform: scale(0.75); transform-origin: center;">
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                            <img src="{{ asset('hitam-putih.svg') }}" alt="{{ $product->nama_produk }}"
                                                data-skeleton-image class="object-contain w-12 h-12 sm:w-20 sm:h-20 opacity-60"
                                                style="display: block;">
                                        </div>
                                    @endif

                                    <!-- Frame (z-20) -->
                                    <img src="{{ asset('frame.png') }}" alt="Frame"
                                        class="absolute inset-0 w-full h-full object-fill pointer-events-none" style="z-index: 20;">

                                    <!-- Overlay Actions (z-40) -->
                                    <div
                                        class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 gap-1 sm:gap-2" style="z-index: 40;">
                                        <a href="{{ route('products.show', $product->id_produk) }}"
                                            class="p-1 sm:p-2 bg-white rounded-full text-gray-800 hover:text-orange-600 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300 text-xs sm:text-base">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-1 sm:p-2 bg-orange-600 rounded-full text-white hover:bg-orange-700 shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75 text-xs sm:text-base">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="p-2 sm:p-4 border-t border-gray-100">
                                    <div class="text-[10px] sm:text-xs text-gray-500 mb-1 line-clamp-1">
                                        {{ $product->brand->nama_brand ?? 'Brand' }}</div>
                                    <a href="{{ route('products.show', $product->id_produk) }}"
                                        class="block text-gray-800 font-medium text-xs sm:text-sm mb-2 hover:text-orange-600 line-clamp-2 min-h-[2em] sm:min-h-[2.5rem]">
                                        {{ $product->nama_produk }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 md:mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-search text-gray-300 text-5xl sm:text-6xl mb-2 sm:mb-4"></i>
                        <h3 class="text-base sm:text-lg font-medium text-gray-600">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-500 mt-2 text-sm sm:text-base">Coba kata kunci lain atau reset filter.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block mt-4 px-4 sm:px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm sm:text-base">Lihat
                            Semua Produk</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection