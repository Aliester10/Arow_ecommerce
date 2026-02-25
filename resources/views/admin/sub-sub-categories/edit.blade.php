@extends('layouts.admin')

@section('title', 'Edit Sub Sub Kategori')

@section('content')
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.sub-sub-categories.index') }}" class="text-gray-700 hover:text-brand-500">
                    Sub Sub Kategori
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Edit Sub Sub Kategori</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700">
    <div class="px-6 py-4 border-b border-stroke dark:border-gray-700">
        <h3 class="text-lg font-semibold text-black dark:text-white">Edit Sub Sub Kategori: {{ $subSubCategory->nama_sub_subkategori }}</h3>
    </div>
    
    <form method="POST" action="{{ route('admin.sub-sub-categories.update', $subSubCategory) }}" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_sub_subkategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Sub Sub Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_sub_subkategori" 
                       id="nama_sub_subkategori" 
                       value="{{ old('nama_sub_subkategori', $subSubCategory->nama_sub_subkategori) }}"
                       required
                       class="w-full rounded-lg border border-stroke dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                @error('nama_sub_subkategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="id_subkategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sub Kategori Induk <span class="text-red-500">*</span>
                </label>
                <select name="id_subkategori" 
                        id="id_subkategori" 
                        required
                        class="w-full rounded-lg border border-stroke dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <option value="">Pilih Sub Kategori</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id_subkategori }}" {{ old('id_subkategori', $subSubCategory->id_subkategori) == $subCategory->id_subkategori ? 'selected' : '' }}>
                            {{ $subCategory->nama_subkategori }} ({{ $subCategory->category?->nama_kategori ?? 'Tidak ada kategori' }})
                        </option>
                    @endforeach
                </select>
                @error('id_subkategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.sub-sub-categories.index') }}" 
               class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Perbarui Sub Sub Kategori
            </button>
        </div>
    </form>
</div>
@endsection
