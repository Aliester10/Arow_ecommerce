<div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 sidebar-container z-30 flex flex-col md:h-96">
    {{-- Header --}}
    <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-100 rounded-t-lg sm:rounded-t-xl" style="background-color:#F7931E">
        <div class="flex items-center text-white font-semibold text-xs sm:text-sm gap-2">
            <i class="fas fa-list text-sm"></i>
            <span>Kategori Produk</span>
        </div>
    </div>

    {{-- List Kategori --}}
    <ul class="divide-y divide-gray-50 pb-2 flex-1 overflow-y-auto">
        @forelse($categories as $category)
            {{-- 
                FORCE STATIC POSITIONING: 
                We use inline style to guarantee this LI is static.
                This forces the absolute submenu child to position relative to the nearest 
                positioned ancestor (.sidebar-container), ensuring it starts at the top.
            --}}
            <li class="group" data-category="{{ $category->id_kategori }}" style="position: static;">
                <a href="{{ route('products.index', ['category' => $category->nama_kategori]) }}"
                   class="flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">
                    <span class="flex items-center gap-2 min-w-0">
                        @php
                            $iconPath = $category->icon_kategori;
                            $isSvg = $iconPath ? (strtolower(pathinfo($iconPath, PATHINFO_EXTENSION)) === 'svg') : false;

                            $iconCandidates = $iconPath ? [
                                $iconPath,
                                'storage/' . ltrim($iconPath, '/'),
                                'storage/images/' . ltrim($iconPath, '/'),
                            ] : [];

                            $resolvedIconPath = null;
                            $resolvedIconFullPath = null;

                            foreach ($iconCandidates as $candidate) {
                                $full = public_path($candidate);
                                if (file_exists($full)) {
                                    $resolvedIconPath = $candidate;
                                    $resolvedIconFullPath = $full;
                                    break;
                                }
                            }

                            $iconExists = (bool) $resolvedIconFullPath;
                        @endphp

                        @if($iconExists && $isSvg)
                            @php
                                $svg = file_get_contents($resolvedIconFullPath);
                                $svg = preg_replace('/<svg(\\s+)/i', '<svg$1style="width:20px;height:20px;" fill="currentColor" stroke="currentColor" ', $svg, 1);

                                $svg = preg_replace('/\sfill="(?!none)[^"]*"/i', ' fill="currentColor"', $svg);
                                $svg = preg_replace('/\sstroke="(?!none)[^"]*"/i', ' stroke="currentColor"', $svg);

                                $svg = preg_replace('/fill\s*:\s*(?!none)[^;\"\']+/i', 'fill:currentColor', $svg);
                                $svg = preg_replace('/stroke\s*:\s*(?!none)[^;\"\']+/i', 'stroke:currentColor', $svg);
                            @endphp
                            <span class="flex-shrink-0" style="color:#F7931E" aria-hidden="true">{!! $svg !!}</span>
                        @elseif($iconExists)
                            <img src="{{ asset($resolvedIconPath) }}" alt="{{ $category->nama_kategori }}" class="w-5 h-5 object-contain flex-shrink-0">
                        @else
                            <span class="w-5 h-5 flex items-center justify-center flex-shrink-0" style="color:#F7931E">
                                <i class="fas fa-tag"></i>
                            </span>
                        @endif
                        <span class="truncate">{{ $category->nama_kategori }}</span>
                    </span>
                </a>

                {{-- Mega Menu Subkategori --}}
                @if($category->subkategori->count() > 0)
                    {{-- 
                        - top: 0 (aligns with sidebar top)
                        - left: calc(100% + 1.5rem) (aligns with banner start)
                        - width: 300% (matches banner width)
                        - height: 24rem (matches md:h-96 banner height)
                        - z-index: 50 (above banner's z-0)
                    --}}
                    <div class="hidden md:block absolute bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 overflow-hidden" 
                         style="top: 0; left: calc(var(--sidebar-width, 33.333333%) + var(--sidebar-gap, 1.5rem)); right: 0; height: var(--mega-height, 24rem); z-index: 50;">
                        <div class="p-6 h-full overflow-y-auto">
                            <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-2">
                                <h4 class="font-bold text-gray-800 text-lg">
                                    {{ $category->nama_kategori }}
                                </h4>
                                <a href="{{ route('products.index', ['category' => $category->nama_kategori]) }}" class="text-xs text-orange-600 hover:underline">
                                    Lihat Semua
                                </a>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                @foreach($category->subkategori as $sub)
                                    <div>
                                        <a href="{{ route('products.index', ['category' => $sub->nama_subkategori]) }}"
                                           class="block text-sm font-semibold text-gray-700 hover:text-orange-600 transition-colors duration-200 py-1">
                                            {{ $sub->nama_subkategori }}
                                        </a>

                                        @if($sub->subSubkategori->count() > 0)
                                            <div class="mt-1 space-y-1">
                                                @foreach($sub->subSubkategori as $subSub)
                                                    <a href="{{ route('products.index', ['category' => $subSub->nama_sub_subkategori]) }}"
                                                       class="block text-xs text-gray-500 hover:text-orange-600 hover:translate-x-1 transition-transform duration-200">
                                                        {{ $subSub->nama_sub_subkategori }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
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
</div>