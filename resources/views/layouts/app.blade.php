<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $perusahaan?->nama_perusahaan ?? 'Arow Ecommerce' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Topbar -->
    <div class="bg-orange-600 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                @if($perusahaan)
                    <div class="flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>{{ $perusahaan->notelp_perusahaan }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>{{ $perusahaan->email_perusahaan }}</span>
                    </div>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:underline">Bantuan</a>
                <a href="#" class="hover:underline">Tentang Kami</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo & Mobile Toggle -->
                <div class="flex items-center">

                    <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-600 flex items-center">
                        @if($perusahaan && $perusahaan->logo_perusahaan)
                            <img src="{{ asset('storage/' . $perusahaan->logo_perusahaan) }}" alt="Logo" class="h-10 md:h-12 w-auto object-contain" style="max-height: 48px;">
                        @else
                            <i class="fas fa-shopping-bag mr-2"></i>
                            {{ $perusahaan?->nama_perusahaan ?? 'AROW' }}
                        @endif
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 mx-4 md:mx-8 relative">
                    <form action="{{ route('products.index') }}" method="GET" class="flex w-full">
                        <div class="flex w-full items-center border border-gray-300 rounded-lg overflow-hidden focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500 transition">
                            <div class="relative h-full flex items-center border-r border-gray-300 bg-gray-50">
                                <select name="category" class="h-full pl-3 pr-8 bg-transparent text-gray-600 text-sm focus:outline-none appearance-none cursor-pointer hover:bg-gray-100 transition py-2.5">
                                    <option value="">Semua</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <input type="text" name="search" placeholder="Cari sekarang hanya di aro baskara era" class="flex-1 px-4 py-2.5 text-sm focus:outline-none border-none w-full">
                            <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 hover:bg-orange-700 transition h-full">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Icons -->
                <div class="flex items-center space-x-6 text-gray-600">
                    <a href="#" class="relative hover:text-orange-600 transition flex flex-col items-center">
                        <div class="relative">
                            <i class="far fa-heart text-2xl"></i>
                            @auth
                                @if($wishlistCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                                @endif
                            @endauth
                        </div>
                        <span class="text-xs mt-1 block">Wishlist</span>
                    </a>
                    
                    <a href="{{ route('cart.index') }}" class="relative hover:text-orange-600 transition flex flex-col items-center">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                            @auth
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                                @endif
                            @endauth
                        </div>
                        <span class="text-xs mt-1 block">Cart</span>
                    </a>

                    <div class="border-l pl-6 border-gray-300">
                        @auth
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-sm font-medium hover:text-orange-600 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 uppercase">
                                        {{ substr(Auth::user()->nama_user, 0, 1) }}
                                    </div>
                                    <span class="block">{{ Str::limit(Auth::user()->nama_user, 10) }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <!-- Dropdown -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-50">
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pesanan Saya</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-2 text-sm font-medium">
                                <a href="{{ route('login') }}" class="hover:text-orange-600">Masuk</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition">Daftar</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Navigation / Categories Bar (Optional) -->
    <nav class="bg-white border-b border-gray-200 block">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-6 overflow-x-auto py-3 text-sm font-medium text-gray-600">
                <div class="relative group">
                    <button class="flex items-center space-x-2 text-orange-600 hover:text-orange-700">
                        <i class="fas fa-bars"></i>
                        <span>KATEGORI</span>
                    </button>
                    <!-- Mega Menu handled in home sidebar, but redundant here if sidebar is always visible. -->
                </div>
                <!-- Other links -->
                <a href="{{ route('home') }}" class="hover:text-orange-600 whitespace-nowrap">Beranda</a>
                <a href="#" class="hover:text-orange-600 whitespace-nowrap">Official Stores</a>
                <a href="#" class="hover:text-orange-600 whitespace-nowrap">Promo Hari Ini</a>
                <a href="#" class="hover:text-orange-600 whitespace-nowrap">Flash Sale</a>
                <a href="#" class="hover:text-orange-600 whitespace-nowrap">Partnership</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="min-h-screen py-6">
        @yield('content')
    </main>

    <!-- Mobile Menu Removed as per user request -->

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Footer content (same as before) -->
                <div>
                    <h3 class="text-orange-600 font-bold mb-4 flex items-center">
                        <i class="fas fa-shopping-bag mr-2"></i> {{ $perusahaan->nama_perusahaan ?? 'AROW' }}
                    </h3>
                    @if($perusahaan)
                        <p class="text-gray-500 text-sm mb-4">{{ $perusahaan->alamat_perusahaan }}</p>
                        <div class="text-gray-500 text-sm">
                            <p class="mb-2"><i class="fas fa-phone-alt mr-2"></i> {{ $perusahaan->notelp_perusahaan }}</p>
                            <p><i class="fas fa-envelope mr-2"></i> {{ $perusahaan->email_perusahaan }}</p>
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-gray-700 mb-4">Layanan Pelanggan</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                         <li><a href="#" class="hover:text-orange-600">Bantuan</a></li>
                        <li><a href="#" class="hover:text-orange-600">Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-orange-600">Lacak Pesanan</a></li>
                        <li><a href="#" class="hover:text-orange-600">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700 mb-4">Jelajahi</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-orange-600">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-orange-600">Karir</a></li>
                        <li><a href="#" class="hover:text-orange-600">Blog</a></li>
                        <li><a href="#" class="hover:text-orange-600">Mitra</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-700 mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-600 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-600 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-orange-600 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} {{ $perusahaan?->nama_perusahaan ?? 'Arow Ecommerce' }}. All rights reserved.
            </div>
        </div>
    </footer>

    <script>

    </script>
</body>
</html>
