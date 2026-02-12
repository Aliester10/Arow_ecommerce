@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
                <!-- Image Gallery -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 relative">
                        <img src="{{ asset('frame.png') }}" alt="Frame" class="absolute inset-0 w-full h-full object-fill">
                        @if($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                    alt="{{ $product->nama_produk }}" class="object-contain w-full h-full"
                                    style="transform: scale(0.75); transform-origin: center;">
                            </div>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-box text-6xl text-gray-300"></i>
                            </div>
                        @endif
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

                    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
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
                                <div
                                    class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
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
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Produk Terkait</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($relatedProducts as $related)
                        <div
                            class="flex flex-col bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition h-full group">
                            <a href="{{ route('products.show', $related->id_produk) }}" class="block w-full h-full flex flex-col">
                                <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                    <img src="{{ asset('frame.png') }}" alt="Frame"
                                        class="absolute inset-0 w-full h-full object-fill z-10">
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

                                    @if($relatedImagePath)
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <img src="{{ asset($relatedImagePath) }}" alt="{{ $related->nama_produk }}"
                                                class="object-contain w-full h-full"
                                                style="transform: scale(0.75); transform-origin: center;">
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <i class="fas fa-box text-2xl text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3 flex flex-col flex-grow">
                                    <h4
                                        class="text-sm font-medium text-gray-800 mb-1 group-hover:text-orange-600 line-clamp-2 transition-colors">
                                        {{ $related->nama_produk }}
                                    </h4>
                                    <div class="mt-auto pt-2 border-t border-gray-50 text-orange-600 font-bold text-sm">
                                        Rp {{ number_format($related->harga_produk, 0, ',', '.') }}
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
@endsection