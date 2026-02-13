@extends('layouts.admin')

@section('header_title', 'Tambah Produk')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Upload Produk Baru</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Produk -->
                <div class="mb-4">
                    <label for="nama_produk" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required value="{{ old('nama_produk') }}">
                </div>

                <!-- Brand & Kategori Row -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="id_brand" class="block text-gray-700 text-sm font-bold mb-2">Brand</label>
                        <div class="relative">
                            <select name="id_brand" id="id_brand"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Pilih Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id_brand }}" {{ old('id_brand') == $brand->id_brand ? 'selected' : '' }}>{{ $brand->nama_brand }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label for="id_sub_subkategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori
                            (Sub-Sub)</label>
                        <div class="relative">
                            <select name="id_sub_subkategori" id="id_sub_subkategori"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach($subSubkategoris as $sub)
                                    <option value="{{ $sub->id_sub_subkategori }}" {{ old('id_sub_subkategori') == $sub->id_sub_subkategori ? 'selected' : '' }}>
                                        {{ $sub->subkategori->kategori->nama_kategori ?? 'Unknown' }} >
                                        {{ $sub->subkategori->nama_subkategori ?? 'Unknown' }} >
                                        {{ $sub->nama_sub_subkategori }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spesifikasi Row 1 -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="sku_produk" class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                        <input type="text" name="sku_produk" id="sku_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('sku_produk') }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label for="tipe_produk" class="block text-gray-700 text-sm font-bold mb-2">Tipe/Cover</label>
                        <input type="text" name="tipe_produk" id="tipe_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('tipe_produk') }}">
                    </div>
                </div>

                <!-- Spesifikasi Row 2 -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="asal_produk" class="block text-gray-700 text-sm font-bold mb-2">Asal Negara</label>
                        <input type="text" name="asal_produk" id="asal_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('asal_produk') }}">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label for="dimensi_produk" class="block text-gray-700 text-sm font-bold mb-2">Dimensi</label>
                        <input type="text" name="dimensi_produk" id="dimensi_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('dimensi_produk') }}">
                    </div>
                </div>

                <!-- Harga & Stok Row -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="stok_produk" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stok_produk" id="stok_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required min="0" value="{{ old('stok_produk') }}">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label for="berat_produk" class="block text-gray-700 text-sm font-bold mb-2">Berat (Gram)</label>
                        <input type="number" name="berat_produk" id="berat_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required min="0" step="0.01" value="{{ old('berat_produk') }}">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi_produk" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi
                        Produk</label>
                    <textarea name="deskripsi_produk" id="deskripsi_produk" rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('deskripsi_produk') }}</textarea>
                </div>

                <!-- Gambar & Status Row -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="gambar_produk" class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk</label>
                        <input type="file" name="gambar_produk" id="gambar_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIFF. Max: 2MB.</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label for="status_produk" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <div class="relative">
                            <select name="status_produk" id="status_produk"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="aktif" {{ old('status_produk') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_produk') == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection