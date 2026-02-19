@extends('layouts.admin')

@section('title', 'Detail Informasi - ' . $promoDetail->judul_detail)

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Informasi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Lihat detail informasi: {{ $promoDetail->judul_detail }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.promo-details.index', $promoBanner->id_promo_banner) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.promo-details.edit', [$promoBanner->id_promo_banner, $promoDetail->id_promo_detail]) }}" 
                   class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi Detail Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Judul Detail
                        </label>
                        <p class="text-gray-900 dark:text-white">{{ $promoDetail->judul_detail }}</p>
                    </div>

                    @if($promoDetail->deskripsi)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Deskripsi
                        </label>
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $promoDetail->deskripsi }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Additional Image -->
            @if($promoDetail->gambar_tambahan)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Gambar Tambahan</h2>
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/images/' . $promoDetail->gambar_tambahan) }}" 
                         alt="{{ $promoDetail->judul_detail }}" 
                         class="w-full h-auto object-cover">
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status & Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Detail</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status
                        </label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Date Information -->
            @if($promoDetail->tanggal_mulai || $promoDetail->tanggal_selesai)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Periode Informasi</h2>
                
                <div class="space-y-3">
                    @if($promoDetail->tanggal_mulai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Mulai
                        </label>
                        <p class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($promoDetail->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                    @endif

                    @if($promoDetail->tanggal_selesai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Selesai
                        </label>
                        <p class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($promoDetail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                    @endif

                    @if($promoDetail->tanggal_mulai && $promoDetail->tanggal_selesai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status Periode
                        </label>
                        @php
                            $now = \Carbon\Carbon::now();
                            $startDate = \Carbon\Carbon::parse($promoDetail->tanggal_mulai);
                            $endDate = \Carbon\Carbon::parse($promoDetail->tanggal_selesai);
                        @endphp
                        @if($now->lt($startDate))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Akan Datang
                            </span>
                        @elseif($now->between($startDate, $endDate))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Sedang Berlangsung
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-history mr-1"></i>Selesai
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Parent Banner Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Banner Terkait</h2>
                
                <div class="space-y-3">
                    @if($promoBanner->gambar_promo_banner)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Gambar Banner
                        </label>
                        <img src="{{ asset('storage/images/' . $promoBanner->gambar_promo_banner) }}" 
                             alt="Informasi Banner" 
                             class="w-full h-32 object-cover rounded-lg">
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status Banner
                        </label>
                        @if($promoBanner->active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
        const button = event.currentTarget;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endsection
