@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Dashboard Overview
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Products Stat -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div
                class="w-14 h-14 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Produk</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $productCount }}</h3>
            </div>
        </div>

        <!-- Brands Stat -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div
                class="w-14 h-14 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Brand</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $brandCount }}</h3>
            </div>
        </div>

        <!-- Banners Stat -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700 p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div
                class="w-14 h-14 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Banner</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $bannerCount }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Selamat Datang di Admin Panel!</h2>
                <p class="text-gray-500 text-sm">Gunakan menu di samping untuk mengelola konten website Anda.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.products.create') }}"
                class="group p-4 border border-stroke dark:border-gray-700 rounded-lg hover:border-orange-500 hover:bg-orange-50 dark:hover:bg-meta-4 transition-all flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i class="fas fa-plus-circle text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                    <span
                        class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-orange-700 dark:group-hover:text-white">Tambah
                        Produk Baru</span>
                </div>
                <i
                    class="fas fa-chevron-right text-gray-300 group-hover:text-orange-400 transition-all transform group-hover:translate-x-1"></i>
            </a>
            <a href="{{ route('admin.brands.create') }}"
                class="group p-4 border border-stroke dark:border-gray-700 rounded-lg hover:border-orange-500 hover:bg-orange-50 dark:hover:bg-meta-4 transition-all flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i class="fas fa-plus-circle text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                    <span
                        class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-orange-700 dark:group-hover:text-white">Tambah
                        Brand Baru</span>
                </div>
                <i
                    class="fas fa-chevron-right text-gray-300 group-hover:text-orange-400 transition-all transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
@endsection