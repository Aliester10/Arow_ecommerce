@extends('layouts.app')

@section('content')
<!-- Hero Section with Breadcrumb -->
<section class="bg-gradient-to-r from-orange-50 to-yellow-50 py-12 md:py-16">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600 transition">
                <i class="fas fa-home"></i>
                <span class="ml-1">Beranda</span>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Lacak Pesanan</span>
        </nav>

        <!-- Title and Description -->
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                Lacak Pesanan
            </h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                Kami menyediakan berbagai metode pengiriman untuk memudahkan pengiriman barang. 
                Pilih jasa pengiriman untuk melacak pesanan Anda.
            </p>
        </div>
    </div>
</section>

<!-- Delivery Services Section -->
<section class="py-12 md:py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
            @forelse($deliveryServices as $service)
                @if($service->url && $service->url !== '#')
                <a href="{{ $service->url }}" 
                   target="_blank"
                   class="group block bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 md:p-12 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border border-yellow-200">
                @else
                <div class="group block bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 md:p-12 shadow-lg border border-gray-200 opacity-75">
                @endif
                    <div class="flex flex-col items-center justify-center h-full min-h-[200px]">
                        @if($service->image_path)
                            <img src="{{ asset('storage/footer_images/' . $service->image_path) }}" 
                                 alt="{{ $service->label }}" 
                                 class="h-24 md:h-32 w-auto object-contain mb-4 group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-24 h-24 md:w-32 md:h-32 bg-orange-200 rounded-full flex items-center justify-center mb-4" style="display:none;">
                                <i class="fas fa-truck text-orange-600 text-3xl md:text-4xl"></i>
                            </div>
                        @else
                            <div class="w-24 h-24 md:w-32 md:h-32 bg-orange-200 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-truck text-orange-600 text-3xl md:text-4xl"></i>
                            </div>
                        @endif
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 text-center group-hover:text-orange-600 transition">
                            {{ $service->label }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2 text-center">
                            @if($service->url && $service->url !== '#')
                                Klik untuk melacak
                            @else
                                <i class="fas fa-tools mr-1"></i>
                                Link akan segera tersedia
                            @endif
                        </p>
                    </div>
                @if($service->url && $service->url !== '#')
                </a>
                @else
                </div>
                @endif
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-box-open text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Jasa Pengiriman</h3>
                    <p class="text-gray-500">
                        Saat ini belum ada jasa pengiriman yang tersedia. Silakan hubungi admin untuk menambahkan layanan pengiriman.
                    </p>
                </div>
            @endforelse
        </div>

        @if($deliveryServices->count() > 0)
        <!-- Additional Info -->
        <div class="mt-12 text-center">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 max-w-2xl mx-auto">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
                    <div class="text-left">
                        <h4 class="font-semibold text-gray-800 mb-2">Cara Melacak Pesanan</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Klik logo jasa pengiriman yang Anda gunakan</li>
                            <li>• Masukkan nomor resi pesanan Anda</li>
                            <li>• Ikuti instruksi pada halaman tracking masing-masing jasa pengiriman</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
