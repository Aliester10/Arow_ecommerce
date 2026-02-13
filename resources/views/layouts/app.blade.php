<!DOCTYPE html>
<html lang="id" data-network-speed="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $perusahaan?->nama_perusahaan ?? 'Arow Ecommerce' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="shortcut icon" href="{{ asset('fav.png') }}" type="image/png">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Topbar -->
    <div class="text-white text-xs sm:text-sm py-2 hidden sm:block" style="background-color:#F7931E">
        <div class="container mx-auto px-2 sm:px-4 flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center flex-wrap gap-2 sm:gap-4">
                @if($perusahaan)
                    <div class="flex items-center gap-1 sm:gap-2">
                        <i class="fas fa-phone-alt"></i>
                        <span class="line-clamp-1">{{ $perusahaan->notelp_perusahaan }}</span>
                    </div>
                    <div class="flex items-center gap-1 sm:gap-2">
                        <i class="fas fa-envelope"></i>
                        <span class="line-clamp-1 hidden sm:inline">{{ $perusahaan->email_perusahaan }}</span>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                <a href="#" class="hover:underline whitespace-nowrap">{{ __('messages.help') }}</a>
                <div id="gtranslate-dropdown" style="position:relative;"></div>
                <a href="#" class="hover:underline whitespace-nowrap">{{ __('messages.about_us') }}</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6">
            <div class="flex justify-between items-center gap-2 sm:gap-4">
                <!-- Logo & Mobile Toggle -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}"
                        class="text-lg sm:text-2xl font-bold text-orange-600 flex items-center gap-1 sm:gap-2">
                        @if($perusahaan && $perusahaan->logo_perusahaan)
                            <img src="{{ asset('storage/images/' . $perusahaan->logo_perusahaan) }}" alt="Logo"
                                class="h-8 sm:h-10 md:h-12 w-auto object-contain" style="max-height: 48px;">
                        @else
                            <i class="fas fa-shopping-bag hidden sm:inline"></i>
                            <span
                                class="line-clamp-1 text-sm sm:text-2xl">{{ $perusahaan?->nama_perusahaan ?? 'AROW' }}</span>
                        @endif
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 relative">
                    <form action="{{ route('products.index') }}" method="GET" class="flex w-full">
                        <div
                            class="flex w-full items-center border border-gray-300 rounded-lg overflow-hidden focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500 transition">
                            <div class="relative h-full flex items-center border-r border-gray-300 bg-gray-50">
                                <select name="category"
                                    class="h-full pl-3 pr-8 bg-transparent text-gray-600 text-sm focus:outline-none appearance-none cursor-pointer hover:bg-gray-100 transition py-2">
                                    <option value="">Semua</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <input type="text" name="search" placeholder="Cari sekarang hanya di aro baskara era"
                                class="flex-1 px-3 py-2 text-xs sm:text-sm focus:outline-none border-none w-full">
                            <button type="submit"
                                class="text-white px-4 sm:px-6 py-2 hover:bg-orange-700 transition h-full text-sm"
                                style="background-color:#F7931E">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Icons -->
                <div class="flex items-center gap-2 sm:gap-4 text-gray-600">
                    <a href="@auth{{ route('wishlist.index') }}@else{{ route('login') }}@endauth"
                        class="relative hover:text-orange-600 transition flex flex-col items-center text-xs sm:text-sm">
                        <div class="relative">
                            <i class="far fa-heart text-lg sm:text-2xl"></i>
                            @auth
                                @if($wishlistCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center text-xs">{{ $wishlistCount }}</span>
                                @endif
                            @endauth
                        </div>

                    </a>

                    <a href="{{ route('cart.index') }}"
                        class="relative hover:text-orange-600 transition flex flex-col items-center text-xs sm:text-sm">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-lg sm:text-2xl"></i>
                            @auth
                                @if($cartCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center text-xs">{{ $cartCount }}</span>
                                @endif
                            @endauth
                        </div>

                    </a>

                    <div class="hidden sm:block border-l pl-4 border-gray-300">
                        @auth
                            <div class="relative group">
                                <button
                                    class="flex items-center gap-1 text-xs sm:text-sm font-medium hover:text-orange-600 focus:outline-none">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 uppercase text-xs">
                                        {{ substr(Auth::user()->nama_user, 0, 1) }}
                                    </div>
                                    <span class="hidden sm:block">{{ Str::limit(Auth::user()->nama_user, 10) }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <!-- Dropdown -->
                                <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block z-50">
                                    <div class="bg-white rounded-md shadow-lg py-1 border border-gray-100">
                                        <a href="{{ route('orders.index') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">Pesanan
                                            Saya</a>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">Profil</a>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Keluar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-xs sm:text-sm font-medium">
                                <a href="{{ route('login') }}" class="hover:text-orange-600">{{ __('messages.login') }}</a>
                                <span class="text-gray-300 hidden sm:inline">|</span>
                                <a href="{{ route('register') }}"
                                    class="px-2 py-1 sm:px-4 sm:py-2 text-white rounded text-xs sm:text-sm hover:bg-orange-700 transition whitespace-nowrap"
                                    style="background-color:#F7931E">{{ __('messages.register') }}</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="block md:hidden mt-2">
                <form action="{{ route('products.index') }}" method="GET" class="flex gap-1">
                    <input type="text" name="search" placeholder="Cari produk..."
                        class="flex-1 px-2 py-1.5 text-xs border border-gray-300 rounded focus:outline-none focus:border-orange-500">
                    <button type="submit"
                        class="bg-orange-600 text-white px-3 py-1.5 rounded hover:bg-orange-700 transition text-xs">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="min-h-screen py-6">
        @yield('content')
    </main>

    <!-- Mobile Menu Removed as per user request -->

    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-12 text-gray-600 text-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-12 lg:gap-20 mb-16">
                <!-- Left Side: Brand & Info (Width ~30% on LG) -->
                <div class="w-full lg:w-4/12 space-y-8">
                    <!-- Logo -->
                    <div class="mb-6">
                        <img src="{{ asset('storage/images/logo/logo.png') }}" alt="Ayobelanja.co.id"
                            class="h-12 md:h-16 object-contain">
                    </div>

                    <!-- Address & Contact Grid -->
                    <div class="space-y-4 text-sm text-gray-500 leading-relaxed">
                        <p>
                            Jl. TM. Slamet Riyadi Raya No. 9 RT.1 RW.4 Kb. Manggis.
                            Kec. Matraman, Daerah Khusus Ibukota Jakarta 13150
                        </p>

                        <div class="space-y-3">
                            <div class="flex items-start gap-4">
                                <div class="w-6 flex justify-center"><i
                                        class="fas fa-phone-alt mt-1 text-orange-500"></i></div>
                                <span>(021) 38835187 / +62 822-8888-6009</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-6 flex justify-center"><i class="fas fa-envelope text-orange-500"></i>
                                </div>
                                <span>sales@ayobelanja.co.id</span>
                            </div>
                        </div>
                    </div>

                    <!-- Member of -->
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Member of</p>
                        <img src="{{ asset('storage/images/logoaro.png') }}" alt="ARO Baskara Esa"
                            class="h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                    </div>
                </div>

                <!-- Right Side: Links Grid (Width ~70% on LG) -->
                <div class="w-full lg:w-8/12">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                        <!-- Col 1: Layanan Pelanggan -->
                        <div class="space-y-6">
                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">Layanan Pelanggan</h4>
                            <ul class="space-y-4 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Bantuan</a></li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Metode Pembayaran</a>
                                </li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Lacak Pesanan</a></li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Kebijakan Privasi</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Col 2: Pengiriman -->
                        <div class="space-y-6">
                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">Pengiriman</h4>
                            <div class="flex items-center gap-4 flex-wrap">
                                <img src="{{ asset('storage/images/tiki.png') }}" alt="TIKI"
                                    class="h-8 object-contain grayscale hover:grayscale-0 transition">
                                <img src="{{ asset('storage/images/JNE.png') }}" alt="JNE"
                                    class="h-8 object-contain grayscale hover:grayscale-0 transition">
                            </div>
                        </div>

                        <!-- Col 3: Jelajahi -->
                        <div class="space-y-6">
                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">Jelajahi</h4>
                            <ul class="space-y-4 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Tentang Kami</a></li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Karir</a></li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Blog</a></li>
                                <li><a href="#" class="hover:text-orange-600 transition-colors">Mitra</a></li>
                            </ul>
                        </div>

                        <!-- Col 4: Ikuti Kami -->
                        <div class="space-y-6">
                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">Ikuti Kami</h4>
                            <div class="flex space-x-3">
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-600 hover:text-white hover:border-orange-600 transition-all shadow-sm">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-600 hover:text-white hover:border-orange-600 transition-all shadow-sm">
                                    <i class="fab fa-instagram text-sm"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-600 hover:text-white hover:border-orange-600 transition-all shadow-sm">
                                    <i class="fab fa-twitter text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="text-center pt-8 border-t border-gray-200 mt-8">
                <p class="text-gray-500 text-xs">
                    &copy; {{ date('Y') }} <strong>Ayobelanja.co.id</strong> | Member of PT. Aro Baskara Esa. All rights
                    reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- Google Translate hidden container (required — must NOT use display:none) --}}
    <div id="google_translate_element" style="height:0;overflow:hidden;position:absolute;left:-9999px;"></div>

    {{-- Flag Dropdown + Google Translate Override Styles --}}
    <style>
        /* Google Translate banner/toolbar override */
        .goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        iframe.goog-te-banner-frame {
            display: none !important;
            height: 0 !important;
            visibility: hidden !important;
        }

        #goog-gt-tt,
        .goog-te-balloon-frame,
        .goog-te-ftab,
        .goog-text-highlight {
            display: none !important;
        }

        html,
        body {
            top: 0 !important;
            margin-top: 0 !important;
            position: static !important;
        }

        body>.skiptranslate {
            display: none !important;
            height: 0 !important;
        }

        /* Flag Dropdown */
        .gtranslate-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            color: #fff;
            padding: 4px 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .gtranslate-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .gtranslate-menu {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 6px;
            display: flex;
            gap: 4px;
            z-index: 9999;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .gtranslate-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 8px;
            color: #e2e8f0;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 600;
            transition: all 0.2s;
            min-width: 44px;
        }

        .gtranslate-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .gtranslate-item.active {
            background: rgba(249, 115, 22, 0.3);
            border-color: rgba(249, 115, 22, 0.5);
            color: #fb923c;
        }
    </style>

    {{-- Google Translate Script --}}
    <script src="{{ asset('js/google-translate.js') }}"></script>
</body>

</html>