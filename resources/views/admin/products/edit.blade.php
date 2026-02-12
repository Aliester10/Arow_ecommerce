@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Produk</h1>

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

            <form action="{{ route('admin.products.update', $product->id_produk) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="mb-4">
                    <label for="nama_produk" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required value="{{ old('nama_produk', $product->nama_produk) }}">
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
                                    <option value="{{ $brand->id_brand }}" {{ old('id_brand', $product->id_brand) == $brand->id_brand ? 'selected' : '' }}>{{ $brand->nama_brand }}
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
                    <div class="w-full md:w-1/2 px-3">
                        <label for="id_sub_subkategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori
                            (Sub-Sub)</label>
                        <div class="relative">
                            <select name="id_sub_subkategori" id="id_sub_subkategori"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach($subSubkategoris as $sub)
                                    <option value="{{ $sub->id_sub_subkategori }}" {{ old('id_sub_subkategori', $product->id_sub_subkategori) == $sub->id_sub_subkategori ? 'selected' : '' }}>
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

                <!-- Harga & Stok Row -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="harga_produk" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" name="harga_produk" id="harga_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required min="0" value="{{ old('harga_produk', $product->harga_produk) }}">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="stok_produk" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stok_produk" id="stok_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required min="0" value="{{ old('stok_produk', $product->stok_produk) }}">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label for="berat_produk" class="block text-gray-700 text-sm font-bold mb-2">Berat (Gram)</label>
                        <input type="number" name="berat_produk" id="berat_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required min="0" step="0.01" value="{{ old('berat_produk', $product->berat_produk) }}">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi_produk" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi
                        Produk</label>
                    <textarea name="deskripsi_produk" id="deskripsi_produk" rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('deskripsi_produk', $product->deskripsi_produk) }}</textarea>
                </div>

                <!-- Gambar & Status Row -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="gambar_produk" class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk
                            (Opsional)</label>
                        <div class="mb-2">
                            @if($product->gambar_produk && file_exists(public_path('storage/images/produk/' . $product->gambar_produk)))
                                <img src="{{ asset('storage/images/produk/' . $product->gambar_produk) }}" alt="Preview"
                                    class="h-24 w-auto object-cover rounded border">
                            @else
                                <p class="text-sm text-gray-500 italic">Tidak ada gambar saat ini</p>
                            @endif
                        </div>
                        <input type="file" name="gambar_produk" id="gambar_produk"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Max: 2MB.</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label for="status_produk" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <div class="relative">
                            <select name="status_produk" id="status_produk"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="aktif" {{ old('status_produk', $product->status_produk) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_produk', $product->status_produk) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection