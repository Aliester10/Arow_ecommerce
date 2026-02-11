<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header --}}
    <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-orange-500 to-orange-600">
        <div class="flex items-center text-white font-semibold text-sm">
            <i class="fas fa-list mr-2 text-base"></i>
            <span>Kategori Produk</span>
        </div>
    </div>

    {{-- List Kategori --}}
    <ul class="divide-y divide-gray-50">
        @forelse($categories as $category)
            <li class="group relative">
                <a href="{{ route('products.index', ['category' => $category->nama_kategori]) }}"
                   class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">
                    <span class="truncate">{{ $category->nama_kategori }}</span>

                    @if($category->subkategori->count() > 0)
                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-orange-600 transition-transform group-hover:translate-x-0.5"></i>
                    @endif
                </a>

                {{-- Mega Menu Subkategori --}}
                @if($category->subkategori->count() > 0)
                    <div class="absolute left-full top-0 ml-1 w-[560px] bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-40">
                        <div class="p-5">
                            <div class="mb-4 pb-3 border-b border-gray-100">
                                <h4 class="font-semibold text-gray-800 text-sm">
                                    {{ $category->nama_kategori }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $category->subkategori->count() }} subkategori
                                </p>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                @foreach($category->subkategori->chunk(ceil($category->subkategori->count() / 3)) as $chunk)
                                    <div class="space-y-2">
                                        @foreach($chunk as $sub)
                                            <a href="{{ route('products.index', ['category' => $sub->nama_kategori]) }}"
                                               class="block px-3 py-2 rounded-lg text-xs text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition">
                                                <i class="fas fa-tag text-[10px] text-gray-400 mr-2"></i>
                                                {{ $sub->nama_kategori }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </li>
        @empty
            <li class="px-4 py-6 text-center text-sm text-gray-500">
                <i class="fas fa-inbox text-gray-300 text-xl mb-2 block"></i>
                Tidak ada kategori
            </li>
        @endforelse
    </ul>

    {{-- Lihat Semua Kategori --}}
    @if($categories->count() > 0)
        <div class="border-t border-gray-100 bg-gray-50">
            <a href="{{ route('products.index') }}"
               class="flex items-center justify-center gap-2 px-4 py-3 text-xs font-semibold text-orange-600 hover:text-orange-700 hover:bg-orange-50 transition">
                <i class="fas fa-th text-xs"></i>
                <span>Lihat Semua Kategori</span>
            </a>
        </div>
    @endif
</div>