@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-brand-500">
                    Kategori
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Edit Kategori</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700">
    <div class="px-6 py-4 border-b border-stroke dark:border-gray-700">
        <h3 class="text-lg font-semibold text-black dark:text-white">Edit Kategori: {{ $category->nama_kategori }}</h3>
    </div>
    
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="max-w-md space-y-6">
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       value="{{ old('nama_kategori', $category->nama_kategori) }}"
                       required
                       class="w-full rounded-lg border border-stroke dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                @error('nama_kategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="icon_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Logo Kategori
                </label>
                <div class="space-y-3">
                    <!-- Current Image Preview -->
                    @if($category->icon_kategori)
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                @if(file_exists(public_path('storage/images/' . $category->icon_kategori)))
                                    <img src="{{ asset('storage/images/' . $category->icon_kategori) }}" 
                                         alt="{{ $category->nama_kategori }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Logo saat ini</p>
                                <p class="text-xs text-gray-500">{{ $category->icon_kategori }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- File Upload -->
                    <input type="file" 
                           name="icon_kategori" 
                           id="icon_kategori" 
                           accept="image/*"
                           class="w-full rounded-lg border border-stroke dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    @error('icon_kategori')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal: 2MB. Kosongkan jika tidak ingin mengubah logo.</p>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.categories.index') }}" 
               class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Perbarui Kategori
            </button>
        </div>
    </form>
</div>
@endsection
