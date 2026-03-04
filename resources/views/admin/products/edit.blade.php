@extends('layouts.admin')



@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Produk
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section (Left -> 2 columns on lg screens) -->
            <div class="flex flex-col gap-6 lg:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Form Edit Produk
                        </h3>
                    </div>

                    @if(session('success'))
                        <div
                            class="m-6.5 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
                            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399]">
                                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3068 6.91894 10.979L15.2925 1.97485C15.6257 1.6091 15.6269 1.04057 15.2984 0.826822Z"
                                        fill="white" stroke="white"></path>
                                </svg>
                            </div>
                            <div class="w-full">
                                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">
                                    Sukses
                                </h5>
                                <p class="text-base leading-relaxed text-body">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="m-6.5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">Periksa kembali inputan anda.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id_produk) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-5">
                            <div class="mb-4">
                                <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                    Nama Produk <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" name="nama_produk"
                                    value="{{ old('nama_produk', $product->nama_produk) }}" required
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                            </div>

                            <!-- Row 1: Brand + Kategori -->
                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Brand <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-gray-700">
                                        <select name="id_brand" required
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-2.5 px-4 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">
                                            <option value="">Pilih Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id_brand }}" {{ old('id_brand', $product->id_brand) == $brand->id_brand ? 'selected' : '' }}>
                                                    {{ $brand->nama_brand }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Kategori <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-gray-700">
                                        <select id="id_kategori" name="id_kategori" required
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-2.5 px-4 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoris as $kat)
                                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $product->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                                    {{ $kat->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Sub Kategori + Sub-Sub Kategori -->
                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Sub Kategori
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-gray-700">
                                        <select id="id_subkategori" name="id_subkategori"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-2.5 px-4 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">
                                            <option value="">Pilih Sub Kategori</option>
                                            @if($product->subkategori)
                                                <option value="{{ $product->id_subkategori }}" selected>
                                                    {{ $product->subkategori->nama_subkategori }}
                                                </option>
                                            @endif
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Kategori (Sub-Sub)
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-gray-700">
                                        <select id="id_sub_subkategori" name="id_sub_subkategori"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">
                                            <option value="">Pilih Sub-Sub Kategori</option>
                                            @if($product->subSubkategori)
                                                <option value="{{ $product->id_sub_subkategori }}" selected>
                                                    {{ $product->subSubkategori->nama_sub_subkategori }}
                                                </option>
                                            @endif
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        SKU
                                    </label>
                                    <input type="text" name="sku_produk"
                                        value="{{ old('sku_produk', $product->sku_produk) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Tipe/Cover
                                    </label>
                                    <input type="text" name="tipe_produk"
                                        value="{{ old('tipe_produk', $product->tipe_produk) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Asal Negara
                                    </label>
                                    <input type="text" name="asal_produk"
                                        value="{{ old('asal_produk', $product->asal_produk) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Dimensi
                                    </label>
                                    <input type="text" name="dimensi_produk"
                                        value="{{ old('dimensi_produk', $product->dimensi_produk) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Harga (Rp)
                                    </label>
                                    <input type="number" name="harga_produk"
                                        value="{{ old('harga_produk', $product->harga_produk) }}" min="0" step="100"
                                        placeholder="0"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Stok <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="number" name="stok_produk"
                                        value="{{ old('stok_produk', $product->stok_produk) }}" required min="0"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Berat (Gram) <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="number" name="berat_produk"
                                        value="{{ old('berat_produk', $product->berat_produk) }}" required min="0"
                                        step="0.01"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4 flex flex-col gap-4 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Spesifikasi Produk
                                    </label>
                                    <textarea name="spesifikasi_produk" rows="5"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">{{ old('spesifikasi_produk', $product->spesifikasi_produk) }}</textarea>
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                        Deskripsi Produk <span class="text-meta-1">*</span>
                                    </label>
                                    <textarea name="deskripsi_produk" rows="5" required
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">{{ old('deskripsi_produk', $product->deskripsi_produk) }}</textarea>
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Gambar Produk (Kosongkan jika tidak diubah)
                                </label>
                                <div class="space-y-4">
                                    <!-- Existing images -->
                                    @if($product->images->count() > 0)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar Saat
                                                Ini:</p>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                                                id="existing-images-container">
                                                @foreach($product->images->sortBy('sort_order') as $image)
                                                    <div class="relative group" data-image-id="{{ $image->id }}">
                                                        <img src="{{ $image->url }}"
                                                            class="w-full h-32 object-cover rounded border border-stroke dark:border-gray-700">
                                                        <div
                                                            class="absolute top-2 right-2 bg-black bg-opacity-50 text-white rounded px-2 py-1 text-xs">
                                                            {{ $image->is_primary ? 'Utama' : '#' . $loop->iteration }}
                                                        </div>
                                                        <button type="button" onclick="deleteExistingImage({{ $image->id }})"
                                                            class="absolute top-2 left-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            ×
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif($product->gambar_produk)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar Saat
                                                Ini:</p>
                                            <img src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}"
                                                class="w-32 h-32 object-cover rounded border border-stroke dark:border-gray-700">
                                        </div>
                                    @endif

                                    <!-- New image upload -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Gambar
                                            Baru:</p>
                                        <div id="image-preview-container"
                                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                                            <!-- Image previews will be shown here -->
                                        </div>
                                        <input type="file" name="gambar_produk[]" multiple accept="image/*"
                                            class="w-full rounded-md border border-stroke p-2.5 text-sm outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-500 dark:bg-gray-700 dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Pilih beberapa gambar untuk
                                            mengganti semua gambar yang ada. Gambar pertama akan menjadi gambar utama.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">
                                    Status <span class="text-meta-1">*</span>
                                </label>
                                <div class="relative z-20 bg-transparent dark:bg-gray-700">
                                    <select name="status_produk" required
                                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-2.5 px-4 text-sm outline-none transition focus:border-primary active:border-primary dark:border-gray-500 dark:bg-gray-700 dark:focus:border-primary">
                                        <option value="aktif" {{ old('status_produk', $product->status_produk) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status_produk', $product->status_produk) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                    <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.8">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                    fill=""></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Update Produk
                            </button>
                        </div>
                </div>
            </div>

            <!-- Live Preview Section (Right -> 1 column sticky on lg screens) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    @include('admin.products._product_preview')
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kategoriSelect = document.getElementById('id_kategori');
            const subkategoriSelect = document.getElementById('id_subkategori');
            const subSubkategoriSelect = document.getElementById('id_sub_subkategori');
            const imageInput = document.querySelector('input[name="gambar_produk[]"]');
            const previewContainer = document.getElementById('image-preview-container');

            // Image preview functionality
            imageInput.addEventListener('change', function (e) {
                previewContainer.innerHTML = '';
                const files = Array.from(e.target.files);

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'relative group';
                        previewDiv.innerHTML = `
                                                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded border border-stroke dark:border-gray-700">
                                                        <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white rounded px-2 py-1 text-xs">
                                                            ${index === 0 ? 'Utama' : '#' + (index + 1)}
                                                        </div>
                                                    `;
                        previewContainer.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Delete existing image
            window.deleteExistingImage = function (imageId) {
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    fetch(`/admin/products/{{ $product->id_produk }}/delete-image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                                if (imageElement) {
                                    imageElement.remove();
                                }
                            }
                        })
                        .catch(error => console.error('Error deleting image:', error));
                }
            };

            // Initial loaded values
            const currentKategoriId = "{{ $product->id_kategori ?? '' }}";
            const currentSubkategoriId = "{{ $product->id_subkategori ?? '' }}";
            const currentSubSubkategoriId = "{{ $product->id_sub_subkategori ?? '' }}";

            function loadSubcategories(kategoriId, selectedSubkategoriId = null) {
                subkategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
                subSubkategoriSelect.innerHTML = '<option value="">Pilih Sub-Sub Kategori</option>';

                if (kategoriId) {
                    fetch(`/admin/products/get-subcategories/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(sub => {
                                    const isSelected = selectedSubkategoriId == sub.id_subkategori ? 'selected' : '';
                                    subkategoriSelect.innerHTML += `<option value="${sub.id_subkategori}" ${isSelected}>${sub.nama_subkategori}</option>`;
                                });

                                // If we have a selected subkategori, load its sub-subcategories too
                                if (selectedSubkategoriId) {
                                    loadSubSubcategories(selectedSubkategoriId, currentSubSubkategoriId);
                                }
                            }
                        })
                        .catch(error => console.error('Error fetching subcategories:', error));
                }
            }

            function loadSubSubcategories(subkategoriId, selectedSubSubkategoriId = null) {
                subSubkategoriSelect.innerHTML = '<option value="">Pilih Sub-Sub Kategori</option>';

                if (subkategoriId) {
                    fetch(`/admin/products/get-sub-subcategories/${subkategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(subSub => {
                                    const isSelected = selectedSubSubkategoriId == subSub.id_sub_subkategori ? 'selected' : '';
                                    subSubkategoriSelect.innerHTML += `<option value="${subSub.id_sub_subkategori}" ${isSelected}>${subSub.nama_sub_subkategori}</option>`;
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching sub-subcategories:', error));
                }
            }

            // On change events
            kategoriSelect.addEventListener('change', function () {
                loadSubcategories(this.value);
            });

            subkategoriSelect.addEventListener('change', function () {
                loadSubSubcategories(this.value);
            });

            // Trigger initial load if editing
            if (kategoriSelect.value) {
                loadSubcategories(kategoriSelect.value, currentSubkategoriId);
            }
        });
    </script>
@endpush