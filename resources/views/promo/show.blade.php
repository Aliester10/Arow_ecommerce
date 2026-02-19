@extends('layouts.app')

@section('title', $promoDetail->judul_detail)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-primary">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="ml-1 text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-primary">Informasi</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 dark:text-gray-400">{{ $promoDetail->judul_detail }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-2">
            <!-- Informasi Banner -->
            @if($promoDetail->promoBanner && $promoDetail->promoBanner->gambar_promo_banner)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/' . $promoDetail->promoBanner->gambar_promo_banner) }}" 
                         alt="{{ $promoDetail->judul_detail }}"
                         class="w-full h-auto object-cover">
                </div>
            @endif

            <!-- Informasi Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $promoDetail->judul_detail }}</h1>
                
                <!-- Date Range -->
                @if($promoDetail->tanggal_mulai && $promoDetail->tanggal_selesai)
                    <div class="flex items-center text-gray-600 dark:text-gray-300 mb-4">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Berlaku: {{ $promoDetail->tanggal_mulai->locale('id')->translatedFormat('d F Y') }} - {{ $promoDetail->tanggal_selesai->locale('id')->translatedFormat('d F Y') }}</span>
                    </div>
                @endif

                <!-- Description -->
                @if($promoDetail->deskripsi)
                    <div class="prose dark:prose-invert max-w-none mb-6">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $promoDetail->deskripsi }}</p>
                    </div>
                @endif

                <!-- Additional Image -->
                @if($promoDetail->gambar_tambahan)
                    <div class="mb-6">
                        <img src="{{ asset('storage/images/' . $promoDetail->gambar_tambahan) }}" 
                             alt="Gambar Tambahan {{ $promoDetail->judul_detail }}"
                             class="w-full h-auto rounded-lg shadow-md">
                    </div>
                @endif

                <!-- Discount Info -->
                @if($promoDetail->diskon_persen || $promoDetail->diskon_nominal)
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-2">
                            <i class="fas fa-tag mr-2"></i>Detail Diskon
                        </h3>
                        @if($promoDetail->diskon_persen)
                            <p class="text-red-700 dark:text-red-400">Diskon: {{ $promoDetail->diskon_persen }}%</p>
                        @endif
                        @if($promoDetail->diskon_nominal)
                            <p class="text-red-700 dark:text-red-400">Diskon: Rp {{ number_format($promoDetail->diskon_nominal, 0, ',', '.') }}</p>
                        @endif
                        @if($promoDetail->min_pembelian)
                            <p class="text-red-700 dark:text-red-400">Minimum pembelian: Rp {{ number_format($promoDetail->min_pembelian, 0, ',', '.') }}</p>
                        @endif
                    </div>
                @endif

                <!-- Promo Code -->
                @if($promoDetail->kode_promo)
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300 mb-2">
                            <i class="fas fa-ticket-alt mr-2"></i>Kode Informasi
                        </h3>
                        <div class="flex items-center justify-between">
                            <code class="text-xl font-bold text-blue-700 dark:text-blue-400">{{ $promoDetail->kode_promo }}</code>
                            <button onclick="copyPromoCode('{{ $promoDetail->kode_promo }}')" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-copy mr-2"></i>Salin
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Terms & Conditions -->
                @if($promoDetail->syarat_ketentuan)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                            <i class="fas fa-file-contract mr-2"></i>Syarat & Ketentuan
                        </h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $promoDetail->syarat_ketentuan }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Related Information -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-fire mr-2 text-orange-500"></i>Informasi Lainnya
                </h3>
                
                @if($relatedPromos->count() > 0)
                    <div class="space-y-4">
                        @foreach($relatedPromos as $related)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
                                 onclick="window.location.href='{{ route('informasi.show', $related->id_promo_detail) }}'">
                                @if($related->promoBanner && $related->promoBanner->gambar_promo_banner)
                                    <img src="{{ asset('storage/images/' . $related->promoBanner->gambar_promo_banner) }}" 
                                         alt="{{ $related->judul_detail }}"
                                         class="w-full h-32 object-cover rounded-lg mb-3">
                                @endif
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $related->judul_detail }}</h4>
                                @if($related->tanggal_mulai && $related->tanggal_selesai)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $related->tanggal_mulai->format('d/m/Y') }} - {{ $related->tanggal_selesai->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400 text-center py-4">
                        <i class="fas fa-info-circle mr-2"></i>Tidak ada informasi lainnya saat ini
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyPromoCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i>Tersalin!';
        button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
        button.classList.add('bg-green-500');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-500');
            button.classList.add('bg-blue-500', 'hover:bg-blue-600');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy promo code: ', err);
    });
}
</script>
@endsection
