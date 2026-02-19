@extends('layouts.admin')

@section('title', 'Detail Informasi')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Informasi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola detail informasi untuk banner yang tersedia
                </p>
            </div>
            <a href="{{ route('admin.promo-banners.create') }}" 
               class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Buat Informasi Banner
            </a>
        </div>
    </div>

    <!-- Empty State -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
        <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada Informasi Banner</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">
            Anda perlu membuat informasi banner terlebih dahulu sebelum dapat menambahkan detail informasi.
        </p>
        <a href="{{ route('admin.promo-banners.create') }}" 
           class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>Buat Informasi Banner Pertama
        </a>
    </div>
</div>
@endsection
