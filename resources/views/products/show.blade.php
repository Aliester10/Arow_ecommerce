@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
                <!-- Image Gallery -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 relative">
                        <!-- Product Image (z-10) -->
                        @if($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                <img id="mainProductImage" src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}" class="object-contain w-full h-full"
                                    style="transform: scale(0.75); transform-origin: center;">
                            </div>
                            <!-- Search Icon Overlay -->
                            <div class="absolute top-4 right-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white/90 p-2 rounded-full shadow-md text-gray-600">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                <i class="fas fa-box text-6xl text-gray-300"></i>
                            </div>
                        @endif
                        <!-- Frame (z-20) -->
                        <img src="{{ asset('frame.png') }}" alt="Frame"
                            class="absolute inset-0 w-full h-full object-fill pointer-events-none" style="z-index: 20;">
                    </div>
                    @if($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                        <div class="flex gap-2">
                            <div
                                class="w-20 h-20 bg-gray-50 rounded-md border border-gray-200 cursor-pointer hover:border-orange-500 transition overflow-hidden">
                                <img src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}" class="w-full h-full object-contain p-2">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="order-2 md:order-none md:col-start-2 md:row-start-1 md:row-span-2">
                    <nav class="flex text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('home') }}" class="hover:text-orange-600">Home</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                                    <a href="{{ route('products.index', ['category' => $product->subSubkategori->subkategori->kategori->nama_kategori ?? 'All']) }}"
                                        class="hover:text-orange-600">{{ $product->subSubkategori->subkategori->kategori->nama_kategori ?? 'Kategori' }}</a>
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
                            Brand: <span
                                class="text-orange-600 font-medium">{{ $product->brand->nama_brand ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                            <span class="text-sm text-gray-600 ml-1 font-bold">4.8</span>
                            <span class="text-sm text-gray-400 ml-1">(12 Ulasan)</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $product->deskripsi_produk }}
                        </p>
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100"
                                    onclick="decrementQty()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stok_produk }}"
                                    class="w-12 text-center text-sm focus:outline-none" readonly>
                                <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100"
                                    onclick="incrementQty()">+</button>
                            </div>
                            <div class="text-sm text-gray-500">
                                Stok: <span class="font-medium">{{ $product->stok_produk }}</span>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            @auth
                                @php
                                    $isWishlisted = \App\Models\Wishlist::where('id_user', \Illuminate\Support\Facades\Auth::user()->id_user)
                                        ->where('id_produk', $product->id_produk)
                                        ->exists();
                                @endphp
                                @if($isWishlisted)
                                    <form action="{{ route('wishlist.destroy', $product->id_produk) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full px-6 py-3 border border-red-600 text-red-600 font-bold rounded-lg hover:bg-red-50 transition flex items-center justify-center">
                                            <i class="fas fa-heart mr-2"></i> Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.store', $product->id_produk) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-6 py-3 border border-orange-600 text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition flex items-center justify-center">
                                            <i class="far fa-heart mr-2"></i> Wishlist
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex-1 px-6 py-3 border border-orange-600 text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition flex items-center justify-center">
                                    <i class="far fa-heart mr-2"></i> Wishlist
                                </a>
                            @endauth

                            <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" id="quantityHidden" value="1">
                                <button type="submit"
                                    class="w-full px-6 py-3 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition flex items-center justify-center">
                                    <i class="fas fa-plus mr-2"></i> Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg border border-gray-100 overflow-hidden order-3 md:order-none md:col-start-1 md:row-start-2">
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
                                        <div class="mt-1 text-yellow-500 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= (int) $review->rating_ulasan ? 'fas' : 'far' }} fa-star"></i>
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
                                    <form action="{{ route('ulasan.store', $product->id_produk) }}" method="POST"
                                        class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                                            <select name="rating_ulasan"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-orange-500"
                                                required>
                                                <option value="">Pilih rating</option>
                                                <option value="5">5</option>
                                                <option value="4">4</option>
                                                <option value="3">3</option>
                                                <option value="2">2</option>
                                                <option value="1">1</option>
                                            </select>
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
                <a href="{{ route('products.index') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm sm:text-base flex items-center gap-1 transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($relatedProducts as $related)
                    <div class="flex flex-col h-full bg-white rounded-lg sm:rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                        <a href="{{ route('products.show', $related->id_produk) }}" class="flex flex-col h-full">
                            <!-- Product Image -->
                            <div class="relative aspect-[4/3] overflow-hidden bg-white shrink-0">
                                @php
                                    $relatedImagePath = null;
                                    if ($related->gambar_produk) {
                                        $rPath1 = 'storage/images/produk/' . $related->gambar_produk;
                                        $rPath2 = 'storage/images/produk/' . str_replace(' ', '', $related->gambar_produk);
                                        $rPath3 = 'storage/images/produk/' . strtolower(str_replace(' ', '', $related->gambar_produk));

                                        if (file_exists(public_path($rPath1)))
                                            $relatedImagePath = $rPath1;
                                        elseif (file_exists(public_path($rPath2)))
                                            $relatedImagePath = $rPath2;
                                        elseif (file_exists(public_path($rPath3)))
                                            $relatedImagePath = $rPath3;
                                    }
                                @endphp

                                <!-- Product Image (z-10) -->
                                @if($relatedImagePath)
                                    <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                        <img src="{{ asset($relatedImagePath) }}" alt="{{ $related->nama_produk }}"
                                            class="object-contain w-full h-full"
                                            style="transform: scale(0.9); transform-origin: center;">
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center" style="z-index: 10;">
                                        <img src="{{ asset('hitam-putih.svg') }}" 
                                             alt="{{ $related->nama_produk }}"
                                             class="object-contain w-12 h-12 sm:w-20 sm:h-20 opacity-60">
                                    </div>
                                @endif

                                <!-- Frame (z-20) -->
                                <img src="{{ asset('frame.png') }}" alt="Frame"
                                    class="absolute inset-0 w-full h-full object-fill pointer-events-none" style="z-index: 20;">
                                
                                <!-- Badges (z-30) -->
                                @if($related->stok_produk <= 0)
                                    <div class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 sm:py-1 rounded-full uppercase tracking-wider shadow-sm" style="z-index: 30;">
                                        Habis
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-3 flex flex-col flex-1 border-t border-gray-100 text-left">
                                <!-- Category/Brand (Meta) -->
                                <div class="text-[9px] sm:text-[10px] text-gray-400 mb-1 uppercase tracking-wider font-bold line-clamp-1">
                                    {{ $related->brand->nama_brand ?? 'Generic' }}
                                </div>
                                <h4 class="text-gray-800 font-medium text-xs sm:text-sm mb-2 hover:text-orange-600 line-clamp-2 leading-snug min-h-[2.5em]">
                                    {{ $related->nama_produk }}
                                </h4>
                                @if($related->harga_produk)
                                    <div class="text-orange-600 font-bold text-sm sm:text-base mt-auto">
                                        Rp {{ number_format($related->harga_produk, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    </div>

    <script>
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
            <div class="absolute top-0 right-0 p-6 z-50 pointer-events-auto">
                <button onclick="closeZoomModal()"
                    class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition backdrop-blur-md border border-white/10 group">
                    <i class="fas fa-times text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>

            <!-- Image Container -->
            <div class="flex-1 flex items-center justify-center overflow-hidden relative pointer-events-auto w-full h-full"
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
                    Scroll • Double Click • Drag
                </p>
            </div>
        </div>
    </div>

    <script>
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

        function openZoomModal() {
            if (!mainImage) return;

            zoomImage.src = mainImage.src;
            resetZoom();

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.addEventListener('keydown', handleEscKey);
        }

        function closeZoomModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            document.removeEventListener('keydown', handleEscKey);
        }

        function handleEscKey(e) {
            if (e.key === 'Escape') closeZoomModal();
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
@endsection