@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Pengaturan Integrated Solutions
        </h2>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col gap-6">
        <!-- Live Preview (Desktop Mode) -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark flex justify-between items-center">
                <h3 class="font-medium text-black dark:text-white">
                    Preview Section
                </h3>
                <span class="text-xs text-gray-500">
                    *Shows current saved configuration
                </span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-boxdark-2 p-6" style="min-height: 400px;">
                @if($integratedSolution && $indexedCategories)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <h4 class="font-bold text-lg mb-3">{{ $integratedSolution->title ?? 'Integrated Solutions' }}</h4>
                        
                        @if($integratedSolution->background_image)
                            <div class="mb-3">
                                <span class="text-sm text-gray-600">Background Image: </span>
                                <img src="{{ asset('storage/images/' . $integratedSolution->background_image) }}" alt="Background" class="h-16 rounded inline-block ml-2">
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($indexedCategories as $index => $category)
                                @if($category && $category->kategori)
                                    <div class="border border-gray-200 rounded p-3">
                                        <div class="font-medium mb-2">{{ $category->kategori->nama_kategori }}</div>
                                        @if($category->category_image)
                                            <img src="{{ asset('storage/images/' . $category->category_image) }}" alt="{{ $category->kategori->nama_kategori }}" class="h-12 w-auto rounded">
                                        @else
                                            <div class="h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="text-xs text-gray-500 mt-2">Layout: Horizontal card with image above</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            This preview shows your current saved configuration. The actual section on the home page will include 4 random subcategories for each selected category.
                        </div>
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <i class="fas fa-cog text-4xl mb-3"></i>
                        <p>No configuration saved yet.</p>
                        <p class="text-sm">Configure your integrated solutions below to see a preview.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Editor Form -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Edit Integrated Solutions
                </h3>
            </div>
            <form action="{{ route('admin.appearance.integrated-solutions.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6.5">
                    <!-- Background Image -->
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Background Image
                        </label>
                        <input type="file" name="background_image" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        @if($integratedSolution && $integratedSolution->background_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/images/' . $integratedSolution->background_image) }}" alt="Current Background" class="h-20 w-auto rounded">
                                <p class="text-sm text-gray-500 mt-1">Current background image</p>
                            </div>
                        @endif
                    </div>

                    <!-- Categories Selection -->
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Pilih Kategori (Maksimal 3)
                        </label>
                        <div class="space-y-2" id="categorySelection">
                            @for($i = 0; $i < 3; $i++)
                                <div class="flex items-center gap-3 category-row" data-index="{{ $i }}">
                                    <select name="categories[{{ $i }}]" class="flex-1 rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary category-select">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id_kategori }}" 
                                                @if(isset($indexedCategories[$i]) && $indexedCategories[$i]->kategori_id == $category->id_kategori) selected @endif>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="file" name="category_images[{{ $i }}]" accept="image/*"
                                        class="rounded-md border border-stroke p-2 outline-none transition file:mr-2 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white category-image" />
                                    @if(isset($indexedCategories[$i]) && $indexedCategories[$i]->image)
                                        <img src="{{ asset('storage/images/' . $indexedCategories[$i]->image) }}" alt="Category Image" class="h-10 w-auto rounded current-image">
                                    @endif
                                </div>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            *Pilih hingga 3 kategori untuk ditampilkan di halaman home
                        </p>
                    </div>

                    <!-- Random Subcategories Info -->
                    <div class="mb-4.5 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Subkategori
                        </h4>
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            Sistem akan secara otomatis mengambil 4 subkategori random dari database untuk setiap kategori yang dipilih.
                        </p>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>

                    <div class="mt-4 text-center space-y-2">
                        <a href="{{ route('admin.appearance.header') }}" class="text-sm text-primary hover:underline block">
                            ← Kembali ke Pengaturan Header
                        </a>
                        <a href="{{ route('admin.appearance.footer') }}" class="text-sm text-primary hover:underline block">
                            Ingin mengedit Footer? Ke Pengaturan Footer →
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
