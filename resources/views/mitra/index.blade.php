@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
            Mitra Kami
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Kami bangga bekerja sama dengan berbagai perusahaan terkemuka untuk memberikan solusi terbaik bagi pelanggan kami.
        </p>
    </div>

    <!-- Mitra Grid -->
    @if($mitra->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-8">
            @foreach($mitra as $partner)
                <div class="flex items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    @if($partner->logo)
                        <img src="{{ asset($partner->logo) }}" 
                             alt="{{ $partner->nama }}" 
                             class="h-16 w-auto max-w-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    @else
                        <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium text-center">
                                {{ Str::limit($partner->nama, 10) }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-handshake text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-lg">
                Belum ada mitra yang ditampilkan.
            </p>
        </div>
    @endif

    <!-- Additional Information -->
    @if($mitra->count() > 0)
        <div class="mt-16 text-center">
            <div class="bg-blue-50 dark:bg-gray-800 rounded-lg p-8 max-w-4xl mx-auto">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">
                    Menjadi Mitra Kami
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Tertarik untuk menjadi mitra bisnis kami? Kami selalu terbuka untuk menjalin kerja sama yang saling menguntungkan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('help.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-blue-600 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-300">
                        <i class="fas fa-phone mr-2"></i>
                        Kontak
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.partner-logo {
    transition: all 0.3s ease;
}

.partner-logo:hover {
    transform: scale(1.05);
}

@media (max-width: 640px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection
