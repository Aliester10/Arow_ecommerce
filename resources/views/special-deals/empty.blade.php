@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-8">

    <!-- Empty State -->
    <div class="text-center py-16 sm:py-24">
        <i class="fas fa-tag text-gray-300 text-6xl sm:text-8xl mb-6"></i>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
            Special Deals Tidak Tersedia
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            Saat ini tidak ada special deals yang tersedia. Silakan kembali lagi nanti.
        </p>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center justify-center rounded-md bg-orange-500 py-3 px-8 text-center font-medium text-white hover:bg-orange-600 transition-colors">
            <i class="fas fa-home mr-2"></i>
            Kembali ke Beranda
        </a>
    </div>

</div>
@endsection
