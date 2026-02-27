@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
                <!-- Image Gallery (Left Column) -->
                <div class="space-y-4 max-w-md mx-auto w-full">
                    <div
                        class="aspect-square bg-white overflow-hidden relative group w-full border border-gray-100 rounded-lg">
                        <!-- Product Images (z-10) -->
                        @if($product->images->count() > 0)
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first();
                                if (!$primaryImage) {
                                    $primaryImage = $product->images->sortBy('sort_order')->first();
                                }
                            @endphp
                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                <img id="mainProductImage" src="{{ $primaryImage->url }}" alt="{{ $product->nama_produk }}"
                                    class="object-contain w-full h-full cursor-pointer" onclick="openZoomModal()">
                            </div>
                            <!-- Search Icon Overlay -->
                            <div class="absolute top-4 right-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white/90 p-2 rounded-full shadow-md text-gray-600 cursor-pointer"
                                    onclick="openZoomModal()">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        @elseif($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                <img id="mainProductImage" src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}" class="object-contain w-full h-full cursor-pointer"
                                    onclick="openZoomModal()">
                            </div>
                            <!-- Search Icon Overlay -->
                            <div class="absolute top-4 right-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white/90 p-2 rounded-full shadow-md text-gray-600 cursor-pointer"
                                    onclick="openZoomModal()">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                <i class="fas fa-box text-6xl text-gray-300"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->images->count() > 0)
                        <div class="flex gap-2 overflow-x-auto pb-2">
                            @foreach($product->images->sortBy('sort_order') as $image)
                                <div class="w-16 h-16 bg-gray-50 rounded-sm border border-gray-200 cursor-pointer hover:border-[#ee4d2d] transition overflow-hidden flex-shrink-0 {{ $image->is_primary ? 'border-[#ee4d2d]' : '' }}"
                                    onclick="changeMainImage('{{ $image->url }}', this)">
                                    <img src="{{ $image->url }}" alt="{{ $product->nama_produk }}"
                                        class="w-full h-full object-contain p-1">
                                </div>
                            @endforeach
                        </div>
                    @elseif($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                        <div class="flex gap-2">
                            <div
                                class="w-16 h-16 bg-gray-50 rounded-sm border-2 border-[#ee4d2d] cursor-pointer overflow-hidden">
                                <img src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}" class="w-full h-full object-contain p-1">
                            </div>
                        </div>
                    @endif

                    <!-- Share & Favorit -->
                    <div class="flex items-center justify-center space-x-8 mt-6 pt-4 text-gray-600">
                        <div class="flex items-center space-x-2 text-sm">
                            <span class="font-medium mr-1">Share:</span>
                            <button class="text-[#0384FF] hover:opacity-80"><i
                                    class="fab fa-facebook-messenger text-xl"></i></button>
                            <button class="text-[#1877F2] hover:opacity-80"><i class="fab fa-facebook text-xl"></i></button>
                            <button class="text-[#E60023] hover:opacity-80"><i
                                    class="fab fa-pinterest text-xl"></i></button>
                            <button class="text-black hover:opacity-80"><i class="fab fa-x-twitter text-xl"></i></button>
                        </div>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <div class="flex items-center text-sm">
                            @auth
                                @php
                                    $isWishlisted = \App\Models\Wishlist::where('id_user', \Illuminate\Support\Facades\Auth::user()->id_user)
                                        ->where('id_produk', $product->id_produk)
                                        ->exists();
                                @endphp
                                @if($isWishlisted)
                                    <form action="{{ route('wishlist.destroy', $product->id_produk) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center text-[#ee4d2d] hover:text-red-600 font-medium transition space-x-2">
                                            <i class="fas fa-heart text-xl"></i>
                                            <span>Favorit
                                                ({{ \App\Models\Wishlist::where('id_produk', $product->id_produk)->count() }})</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.store', $product->id_produk) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center text-gray-500 hover:text-[#ee4d2d] font-medium transition space-x-2">
                                            <i class="far fa-heart text-xl"></i>
                                            <span>Favorit
                                                ({{ \App\Models\Wishlist::where('id_produk', $product->id_produk)->count() }})</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex items-center text-gray-500 hover:text-[#ee4d2d] font-medium transition space-x-2">
                                    <i class="far fa-heart text-xl"></i>
                                    <span>Favorit
                                        ({{ \App\Models\Wishlist::where('id_produk', $product->id_produk)->count() }})</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Product Info (Right Column) -->
                <div class="mt-6 md:mt-0 lg:pr-8">
                    <!-- Title & Ratings -->
                    <h1 class="text-xl md:text-[22px] font-medium text-gray-900 mb-3 leading-tight">
                        {{ $product->nama_produk }}
                    </h1>

                    <div class="flex flex-wrap items-center mb-4 text-sm">
                        <div class="flex items-center text-[#ee4d2d] pr-4 border-r border-gray-300">
                            <span class="font-medium mr-1 border-b border-[#ee4d2d]">4.9</span>
                            <div class="flex space-x-0.5 text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="px-4 border-r border-gray-300 text-gray-700">
                            <span class="font-medium border-b border-gray-700">13</span> <span
                                class="text-gray-500 ml-1">Penilaian</span>
                        </div>
                        <div class="px-4 text-gray-700">
                            <span class="font-medium">{{ $product->stok_produk > 0 ? rand(10, 500) : 0 }}</span> <span
                                class="text-gray-500 ml-1">Terjual</span>
                        </div>

                        <div class="ml-auto text-gray-400 text-sm hover:text-gray-600 cursor-pointer">
                            Laporkan
                        </div>
                    </div>

                    <!-- Price Block -->
                    <div class="bg-[#fafafa] px-5 py-4 mb-6 flex flex-col justify-center min-h-[80px]">
                        <div class="flex items-baseline space-x-3">
                            @if($product->harga_diskon && $product->harga_diskon < $product->harga_produk)
                                <span
                                    class="text-base text-gray-400 line-through">Rp{{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                                <span
                                    class="text-3xl font-medium text-[#ee4d2d]">Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                            @else
                                <span
                                    class="text-3xl font-medium text-[#ee4d2d]">Rp{{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="space-y-4 md:space-y-6 mb-8 text-sm">

                        <div class="flex items-start">
                            <div class="w-[120px] text-gray-500 font-medium pt-1">Pengiriman</div>
                            <div class="flex-1 text-gray-700">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-truck text-gray-500 mr-2 w-4"></i>
                                    <span>Layanan Pengiriman Reguler</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-[120px] text-gray-500 font-medium pt-1">Kategori</div>
                            <div class="flex-1 text-gray-700 font-medium text-[#0384FF] cursor-pointer">
                                {{ $product->subSubkategori->subkategori->kategori->nama_kategori ?? 'Semua' }} >
                                {{ $product->subSubkategori->subkategori->nama_subkategori ?? 'Produk' }} >
                                {{ $product->subSubkategori->nama_sub_subkategori ?? 'Item' }}
                            </div>
                        </div>

                        <div class="flex items-center mt-6">
                            <div class="w-[120px] text-gray-500 font-medium">Kuantitas</div>
                            <div class="flex-1 flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-sm overflow-hidden">
                                    <button type="button"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white hover:bg-gray-50 border-r border-gray-300 transition-colors"
                                        onclick="decrementQty()">
                                        <i class="fas fa-minus text-[10px]"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stok_produk }}"
                                        class="w-12 h-8 text-center text-gray-700 focus:outline-none text-[15px]" readonly>
                                    <button type="button"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 bg-white hover:bg-gray-50 border-l border-gray-300 transition-colors"
                                        onclick="incrementQty()">
                                        <i class="fas fa-plus text-[10px]"></i>
                                    </button>
                                </div>
                                <div class="text-gray-500">
                                    Tersisa {{ $product->stok_produk }} Buah
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 mt-8">
                        <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" id="addToCartForm"
                            class="mr-1">
                            @csrf
                            <input type="hidden" name="quantity" id="quantityHidden" value="1">
                            <button type="submit"
                                class="px-6 md:px-10 py-3 bg-[#ffeee8] border border-[#ee4d2d] text-[#ee4d2d] font-medium rounded-sm hover:bg-[#ffe4dc] transition flex items-center justify-center min-w-[180px]">
                                <i class="fas fa-cart-plus mr-2 text-lg"></i> Masukkan Keranjang
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('addToCartForm').submit()"
                            class="px-6 md:px-10 py-3 bg-[#ee4d2d] text-white font-medium rounded-sm hover:bg-[#d73f22] transition flex flex-col items-center justify-center min-w-[180px] shadow-sm">
                            <span>Beli Sekarang</span>
                        </button>
                    </div>
                </div>
            </div> <!-- End Flex Top Section -->

            <!-- Bottom Specs Section (Full Width) -->
            <div class="px-6 md:px-8 pb-8">
                <div class="bg-white rounded-lg border border-gray-100 overflow-hidden w-full">
                    <div class="flex border-b border-gray-100">
                        <button type="button" id="tabSpecBtn"
                            class="flex-1 px-4 py-3 text-sm font-semibold text-orange-600 border-b-2 border-orange-600 bg-orange-50">
                            Spesifikasi Produk
                        </button>
                        <button type="button" id="tabReviewBtn"
                            class="flex-1 px-4 py-3 text-sm font-semibold text-gray-600 hover:text-orange-600">
                            Ulasan
                        </button>
                    </div>

                    <div id="tabSpec" class="p-4">
                        <dl class="text-sm divide-y divide-gray-100">
                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">NAMA</dt>
                                <dd class="col-span-2 font-medium text-gray-800">{{ $product->nama_produk }}</dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">MEREK</dt>
                                <dd class="col-span-2 font-medium text-gray-800">
                                    {{ $product->brand->nama_brand ?? '-' }}
                                </dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">SKU</dt>
                                <dd class="col-span-2 font-medium text-gray-800">{{ $product->sku_produk ?? '-' }}</dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">TYPE/COVER</dt>
                                <dd class="col-span-2 font-medium text-gray-800">{{ $product->tipe_produk ?? '-' }}</dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">ASAL NEGARA</dt>
                                <dd class="col-span-2 font-medium text-gray-800">{{ $product->asal_produk ?? '-' }}</dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">SUB KATEGORI</dt>
                                <dd class="col-span-2 font-medium text-gray-800">
                                    {{ $product->subSubkategori->subkategori->nama_subkategori ?? '-' }}
                                </dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">SUB SUB KATEGORI</dt>
                                <dd class="col-span-2 font-medium text-gray-800">
                                    {{ $product->subSubkategori->nama_sub_subkategori ?? '-' }}
                                </dd>
                            </div>

                            <div class="grid grid-cols-3 gap-3 py-2">
                                <dt class="text-gray-500">DIMENSI</dt>
                                <dd class="col-span-2 font-medium text-gray-800">{{ $product->dimensi_produk ?? '-' }}
                                </dd>
                            </div>
                        </dl>

                        @if($product->spesifikasi_produk)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="text-sm font-semibold text-gray-800 mb-2">Spesifikasi</div>
                                <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                    {{ $product->spesifikasi_produk }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="tabReview" class="p-4 hidden">
                        @if(session('success'))
                            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            @if($product->ulasan->count() > 0)
                                @foreach($product->ulasan as $review)
                                    <div class="border border-gray-100 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm font-semibold text-gray-800">
                                                {{ $review->user->nama_user ?? 'User' }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($review->tanggal_ulasan)->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="mt-1 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="{{ $i <= (int) $review->rating_ulasan ? 'fas text-yellow-500' : 'far text-gray-300' }} fa-star"></i>
                                            @endfor
                                        </div>
                                        @if($review->komentar_ulasan)
                                            <div class="mt-2 text-sm text-gray-600">{{ $review->komentar_ulasan }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-sm text-gray-500">Belum ada ulasan.</div>
                            @endif

                            <div class="border-t border-gray-100 pt-4">
                                @auth
                                    <form action="{{ route('ulasan.store', $product->slug) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                                            <div class="flex items-center space-x-1" id="starRating">
                                                <input type="hidden" name="rating_ulasan" id="ratingInput" required>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button"
                                                        class="star-btn text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none transform hover:scale-110 duration-200"
                                                        data-value="{{ $i }}">
                                                        <i class="fas fa-star text-2xl"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 font-medium" id="ratingText">Klik bintang untuk
                                                memberi nilai</p>
                                            @error('rating_ulasan')
                                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Komentar</label>
                                            <textarea name="komentar_ulasan" rows="3"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                                placeholder="Tulis ulasan..."></textarea>
                                            @error('komentar_ulasan')
                                                <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-semibold">
                                            Kirim Ulasan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-semibold">
                                        Login untuk memberi ulasan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-star text-orange-500 text-xl"></i>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Produk Terkait</h3>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="text-orange-500 hover:text-orange-600 font-medium text-sm sm:text-base flex items-center gap-1 transition-colors">
                        Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($relatedProducts as $related)
                        <div class="flex flex-col h-full bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300"
                            data-skeleton-container style="border-radius: 8px; overflow: hidden;">
                            <a href="{{ route('products.show', $related->slug) }}" class="flex flex-col h-full relative group">
                                <!-- Product Image -->
                                <div class="relative w-full overflow-hidden bg-white shrink-0" style="aspect-ratio: 1/1;">
                                    @php
                                        $relatedImagePath = \Illuminate\Support\Facades\Cache::remember('img_path_' . md5($related->id_produk ?? $related->gambar_produk ?? 'none'), 86400, function () use ($related) {
                                            if (!$related->gambar_produk)
                                                return null;
                                            $p1 = 'storage/images/produk/' . $related->gambar_produk;
                                            if (file_exists(public_path($p1)))
                                                return $p1;
                                            $p2 = 'storage/images/produk/' . str_replace(' ', '', $related->gambar_produk);
                                            if (file_exists(public_path($p2)))
                                                return $p2;
                                            $p3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $related->gambar_produk));
                                            if (file_exists(public_path($p3)))
                                                return $p3;
                                            return null;
                                        });
                                    @endphp

                                    @if($relatedImagePath)
                                        <div data-skeleton
                                            class="skeleton-shimmer w-full h-full flex items-center justify-center bg-gray-200 absolute inset-0"
                                            style="z-index: 30;"></div>
                                        <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                            <img src="{{ asset($relatedImagePath) }}" alt="{{ $related->nama_produk }}"
                                                class="w-full h-full object-contain" data-skeleton-image loading="lazy">
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center bg-gray-50" style="z-index: 10;">
                                            <i class="fas fa-image text-gray-300 text-3xl"></i>
                                        </div>
                                    @endif

                                    <!-- Out of Stock Badge -->
                                    @if($related->stok_produk <= 0)
                                        <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 sm:py-1 rounded-full uppercase tracking-wider shadow-sm"
                                            style="z-index: 40;">
                                            Habis
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex flex-col flex-grow p-3 bg-white">
                                    <!-- Product Name -->
                                    <h3
                                        class="text-[13px] text-gray-800 mb-2 line-clamp-2 leading-[1.3] min-h-[34px] group-hover:text-blue-600 transition-colors">
                                        {{ $related->nama_produk }}
                                    </h3>

                                    <!-- Price Section -->
                                    <div class="mt-auto">
                                        <p class="text-[11px] text-gray-500 mb-0.5">Mulai dari</p>
                                        @if($related->harga_diskon && $related->harga_diskon < $related->harga_produk)
                                            <span class="text-[15px] font-bold text-[#eab308]">
                                                Rp {{ number_format($related->harga_diskon, 0, ',', '.') }},00
                                            </span>
                                        @else
                                            <span class="text-[15px] font-bold text-[#eab308]">
                                                Rp {{ number_format($related->harga_produk, 0, ',', '.') }},00
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Seller Info -->
                                    <div class="mt-3 flex flex-col gap-1">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-blue-500 text-[10px]"></i>
                                            <span
                                                class="text-[11px] font-bold text-[#1e3a8a] tracking-tight truncate">{{ $related->asal_produk ?: 'Indonesia' }}</span>
                                        </div>
                                        <div class="text-[11px] text-gray-400">
                                            Tipe: {{ $related->tipe_produk ?: '-' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        function changeMainImage(imageUrl) {
            const mainImage = document.getElementById('mainProductImage');
            if (mainImage) {
                mainImage.src = imageUrl;
            }
        }

        function incrementQty() {
            const input = document.getElementById('quantity');
            const hidden = document.getElementById('quantityHidden');
            const max = parseInt(input.getAttribute('max'));
            let val = parseInt(input.value);
            if (val < max) {
                input.value = val + 1;
                if (hidden) hidden.value = input.value;
            }
        }

        function decrementQty() {
            const input = document.getElementById('quantity');
            const hidden = document.getElementById('quantityHidden');
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                if (hidden) hidden.value = input.value;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const specBtn = document.getElementById('tabSpecBtn');
            const reviewBtn = document.getElementById('tabReviewBtn');
            const specTab = document.getElementById('tabSpec');
            const reviewTab = document.getElementById('tabReview');

            if (!specBtn || !reviewBtn || !specTab || !reviewTab) return;

            function setActive(active) {
                if (active === 'spec') {
                    specTab.classList.remove('hidden');
                    reviewTab.classList.add('hidden');
                    specBtn.classList.add('text-orange-600', 'border-b-2', 'border-orange-600', 'bg-orange-50');
                    specBtn.classList.remove('text-gray-600');
                    reviewBtn.classList.remove('text-orange-600', 'border-b-2', 'border-orange-600', 'bg-orange-50');
                    reviewBtn.classList.add('text-gray-600');
                } else {
                    reviewTab.classList.remove('hidden');
                    specTab.classList.add('hidden');
                    reviewBtn.classList.add('text-orange-600', 'border-b-2', 'border-orange-600', 'bg-orange-50');
                    reviewBtn.classList.remove('text-gray-600');
                    specBtn.classList.remove('text-orange-600', 'border-b-2', 'border-orange-600', 'bg-orange-50');
                    specBtn.classList.add('text-gray-600');
                }
            }

            specBtn.addEventListener('click', function () { setActive('spec'); });
            reviewBtn.addEventListener('click', function () { setActive('review'); });
        });
    </script>

    <!-- Zoom Modal -->
    <div id="zoomModal" class="hidden" style="position: fixed; inset: 0; z-index: 99999; width: 100vw; height: 100vh;">
        <!-- Background backdrop -->
        <div class="absolute inset-0 transition-opacity backdrop-blur-sm" style="background-color: rgba(0, 0, 0, 0.9);"
            onclick="closeZoomModal()"></div>

        <!-- Content container -->
        <div class="relative w-full h-full flex flex-col pointer-events-none">

            <!-- Header (Close only) -->
            <div class="absolute top-0 right-0 p-6 z-50 pointer-events-auto flex items-center gap-4">
                <span id="zoomImageCounter" class="text-white/70 font-mono text-sm tracking-wider mr-2 font-medium">1 /
                    1</span>
                <button onclick="closeZoomModal()"
                    class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition backdrop-blur-md border border-white/10 group">
                    <i class="fas fa-times text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>

            <!-- Navigation Buttons (Prev/Next) -->
            <button id="zoomPrevBtn" onclick="zoomPrevImage(event)"
                class="absolute left-4 sm:left-10 top-1/2 -translate-y-1/2 z-40 pointer-events-auto w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center transition-all backdrop-blur-md border border-white/10 opacity-0 group-hover:opacity-100 hidden">
                <i class="fas fa-chevron-left text-xl sm:text-2xl"></i>
            </button>
            <button id="zoomNextBtn" onclick="zoomNextImage(event)"
                class="absolute right-4 sm:right-10 top-1/2 -translate-y-1/2 z-40 pointer-events-auto w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center transition-all backdrop-blur-md border border-white/10 opacity-0 group-hover:opacity-100 hidden">
                <i class="fas fa-chevron-right text-xl sm:text-2xl"></i>
            </button>

            <!-- Image Container -->
            <div class="flex-1 flex items-center justify-center overflow-hidden relative pointer-events-auto w-full h-full group"
                id="zoomContainer" onmousedown="startDrag(event)" onmousemove="drag(event)" onmouseup="endDrag()"
                onmouseleave="endDrag()" onwheel="handleWheel(event)" ondblclick="toggleZoom(event)">

                <img id="zoomImage" src="" alt="Zoomed Product"
                    class="max-w-none transition-transform duration-100 ease-out select-none will-change-transform shadow-2xl"
                    style="transform: scale(1) translate(0px, 0px); max-height: 90vh; max-width: 90vw; object-fit: contain;">

            </div>

            <!-- Bottom Controls -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-50 pointer-events-auto" style="width: max-content;">
                <div class="rounded-full px-6 py-3 flex items-center gap-6 backdrop-blur-xl border border-white/10 shadow-2xl"
                    style="background-color: rgba(20, 20, 20, 0.8);">
                    <button onclick="zoomOut()"
                        class="text-white/80 hover:text-white hover:scale-110 transition active:scale-95" title="Zoom Out">
                        <i class="fas fa-minus text-lg"></i>
                    </button>

                    <span id="zoomLevelDisplay"
                        class="text-white font-mono font-medium text-sm w-12 text-center select-none">100%</span>

                    <button onclick="zoomIn()"
                        class="text-white/80 hover:text-white hover:scale-110 transition active:scale-95" title="Zoom In">
                        <i class="fas fa-plus text-lg"></i>
                    </button>

                    <div class="w-px h-5 bg-white/20"></div>

                    <button onclick="resetZoom()"
                        class="text-white/80 hover:text-white hover:scale-110 transition active:scale-95"
                        title="Reset View">
                        <i class="fas fa-expand text-lg"></i>
                    </button>
                </div>
                <p class="text-white/30 text-[10px] text-center mt-3 font-light tracking-wider uppercase">
                    Scroll • Double Click • Drag • Left/Right Arrow
                </p>
            </div>
        </div>
    </div>

    <script>
        // Gallery Array from PHP
        const productGallery = [
            @if($product->images->count() > 0)
                @foreach($product->images->sortBy('sort_order') as $image)
                    '{{ $image->url }}',
                @endforeach
            @elseif($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                '{{ asset('storage/images/produk/' . $product->gambar_produk) }}'
            @endif
                                    ];

        let currentGalleryIndex = 0;

        // Zoom functionality variables
        let scale = 1;
        let pannedX = 0;
        let pannedY = 0;
        let isDragging = false;
        let startX = 0;
        let startY = 0;
        const zoomStep = 0.5;
        const maxZoom = 5;
        const minZoom = 1;

        const modal = document.getElementById('zoomModal');
        const zoomImage = document.getElementById('zoomImage');
        const zoomDisplay = document.getElementById('zoomLevelDisplay');
        const mainImage = document.getElementById('mainProductImage');

        const zoomPrevBtn = document.getElementById('zoomPrevBtn');
        const zoomNextBtn = document.getElementById('zoomNextBtn');
        const zoomImageCounter = document.getElementById('zoomImageCounter');

        function updateGalleryUI() {
            if (productGallery.length <= 1) {
                if (zoomPrevBtn) zoomPrevBtn.style.display = 'none';
                if (zoomNextBtn) zoomNextBtn.style.display = 'none';
                if (zoomImageCounter) zoomImageCounter.style.display = 'none';
                return;
            }

            if (zoomPrevBtn) zoomPrevBtn.style.display = 'flex';
            if (zoomNextBtn) zoomNextBtn.style.display = 'flex';
            if (zoomImageCounter) {
                zoomImageCounter.style.display = 'inline-block';
                zoomImageCounter.innerText = `${currentGalleryIndex + 1} / ${productGallery.length}`;
            }
        }

        function zoomPrevImage(e) {
            if (e) e.stopPropagation();
            if (productGallery.length <= 1) return;

            currentGalleryIndex = (currentGalleryIndex - 1 + productGallery.length) % productGallery.length;
            zoomImage.src = productGallery[currentGalleryIndex];
            mainImage.src = productGallery[currentGalleryIndex]; // sync background thumb
            resetZoom();
            updateGalleryUI();
        }

        function zoomNextImage(e) {
            if (e) e.stopPropagation();
            if (productGallery.length <= 1) return;

            currentGalleryIndex = (currentGalleryIndex + 1) % productGallery.length;
            zoomImage.src = productGallery[currentGalleryIndex];
            mainImage.src = productGallery[currentGalleryIndex]; // sync background thumb
            resetZoom();
            updateGalleryUI();
        }

        function openZoomModal() {
            if (!mainImage) return;

            // Find current image in gallery array
            if (productGallery.length > 0) {
                const currentSrc = mainImage.src;
                // find index by matching ending of URL to handle domain differences if any
                const idx = productGallery.findIndex(url => currentSrc.includes(url) || url.includes(currentSrc));
                if (idx !== -1) currentGalleryIndex = idx;
            }

            zoomImage.src = mainImage.src;
            resetZoom();
            updateGalleryUI();

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.addEventListener('keydown', handleGlobalKeydown);
        }

        function closeZoomModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            document.removeEventListener('keydown', handleGlobalKeydown);
        }

        function handleGlobalKeydown(e) {
            if (e.key === 'Escape') closeZoomModal();
            else if (e.key === 'ArrowLeft') zoomPrevImage();
            else if (e.key === 'ArrowRight') zoomNextImage();
        }

        function updateTransform() {
            if (scale <= 1) {
                pannedX = 0;
                pannedY = 0;
                scale = 1;
            }

            zoomImage.style.transform = `translate(${pannedX}px, ${pannedY}px) scale(${scale})`;
            zoomDisplay.innerText = Math.round(scale * 100) + '%';

            const container = document.getElementById('zoomContainer');
            if (scale > 1) {
                container.style.cursor = isDragging ? 'grabbing' : 'grab';
            } else {
                container.style.cursor = 'default';
            }
        }

        function toggleZoom(e) {
            if (scale > 1) {
                resetZoom();
            } else {
                scale = 2.5;
                updateTransform();
            }
        }

        function zoomIn() {
            if (scale < maxZoom) {
                scale = Math.min(scale + zoomStep, maxZoom);
                updateTransform();
            }
        }

        function zoomOut() {
            if (scale > minZoom) {
                scale = Math.max(scale - zoomStep, minZoom);
                updateTransform();
            }
        }

        function resetZoom() {
            scale = 1;
            pannedX = 0;
            pannedY = 0;
            updateTransform();
        }

        function handleWheel(e) {
            e.preventDefault();
            const delta = e.deltaY * -0.001;
            const newScale = Math.min(Math.max(minZoom, scale + delta * 5), maxZoom);

            if (newScale !== scale) {
                scale = newScale;
                updateTransform();
            }
        }

        function startDrag(e) {
            if (scale > 1) {
                isDragging = true;
                startX = e.clientX - pannedX;
                startY = e.clientY - pannedY;
                zoomImage.style.transition = 'none';
            }
        }

        function drag(e) {
            if (!isDragging) return;
            e.preventDefault();
            pannedX = e.clientX - startX;
            pannedY = e.clientY - startY;

            zoomImage.style.transform = `translate(${pannedX}px, ${pannedY}px) scale(${scale})`;
        }

        function endDrag() {
            isDragging = false;
            zoomImage.style.transition = 'transform 0.1s ease-out';
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Star Rating Logic
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.getElementById('ratingText');
            const labels = {
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Biasa',
                4: 'Bagus',
                5: 'Sempurna'
            };

            function updateStars(value) {
                stars.forEach(star => {
                    const starVal = parseInt(star.getAttribute('data-value'));
                    const icon = star.querySelector('i');
                    if (starVal <= value) {
                        icon.classList.remove('text-gray-300');
                        icon.classList.add('text-yellow-400');
                    } else {
                        icon.classList.remove('text-yellow-400');
                        icon.classList.add('text-gray-300');
                    }
                });
            }

            if (stars.length > 0) {
                stars.forEach(star => {
                    star.addEventListener('mouseenter', function () {
                        const value = parseInt(this.getAttribute('data-value'));
                        updateStars(value);
                        if (ratingText) ratingText.textContent = value + ' - ' + labels[value];
                    });

                    star.addEventListener('mouseleave', function () {
                        const currentValue = parseInt(ratingInput.value) || 0;
                        updateStars(currentValue);
                        if (ratingText) {
                            if (currentValue > 0) {
                                ratingText.textContent = currentValue + ' - ' + labels[currentValue];
                            } else {
                                ratingText.textContent = 'Klik bintang untuk memberi nilai';
                            }
                        }
                    });

                    star.addEventListener('click', function () {
                        const value = parseInt(this.getAttribute('data-value'));
                        if (ratingInput) ratingInput.value = value;
                        updateStars(value); // Force update to ensure correct visual state
                        if (ratingText) ratingText.textContent = value + ' - ' + labels[value];

                        // Add simple animation
                        const icon = this.querySelector('i');
                        icon.classList.add('scale-125');
                        setTimeout(() => {
                            icon.classList.remove('scale-125');
                        }, 200);
                    });
                });
            }
        });
    </script>
@endsection