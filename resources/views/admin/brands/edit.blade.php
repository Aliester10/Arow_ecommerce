@extends('layouts.admin')

@section('header_title', 'Edit Brand')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Brand: {{ $brand->nama_brand }}</h1>
                <a href="{{ route('admin.brands.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.brands.update', $brand->id_brand) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_brand" class="block text-gray-700 text-sm font-bold mb-2">Nama Brand</label>
                    <input type="text" name="nama_brand" id="nama_brand"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required value="{{ old('nama_brand', $brand->nama_brand) }}">
                </div>

                <div class="mb-4">
                    <label for="deskripsi_brand" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi
                        (Opsional)</label>
                    <textarea name="deskripsi_brand" id="deskripsi_brand" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('deskripsi_brand', $brand->deskripsi_brand) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Logo Brand</label>
                        <div class="mb-3">
                            @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" alt="Current Logo"
                                    class="w-24 h-24 object-contain rounded border">
                            @else
                                <div class="w-24 h-24 bg-gray-100 flex items-center justify-center rounded border">
                                    <i class="fas fa-image text-gray-300 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="logo_brand" id="logo_brand"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah logo.</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Background Brand</label>
                        <div class="mb-3">
                            @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                <img src="{{ asset('storage/images/' . $brand->gambar_background) }}" alt="Current BG"
                                    class="w-full h-24 object-cover rounded border">
                            @else
                                <div class="w-full h-24 bg-gray-100 flex items-center justify-center rounded border">
                                    <i class="fas fa-image text-gray-300 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="gambar_background" id="gambar_background"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah background.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection