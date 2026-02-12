@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Brand Baru</h1>
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

            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="nama_brand" class="block text-gray-700 text-sm font-bold mb-2">Nama Brand</label>
                    <input type="text" name="nama_brand" id="nama_brand"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required value="{{ old('nama_brand') }}" placeholder="Contoh: Aceh Autoparts">
                </div>

                <div class="mb-4">
                    <label for="deskripsi_brand" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi
                        (Opsional)</label>
                    <textarea name="deskripsi_brand" id="deskripsi_brand" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Deskripsi singkat brand">{{ old('deskripsi_brand') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="logo_brand" class="block text-gray-700 text-sm font-bold mb-2">Logo Brand (PNG/SVG
                            recommended)</label>
                        <input type="file" name="logo_brand" id="logo_brand"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Logo yang akan tampil di bulatan kecil.</p>
                    </div>
                    <div>
                        <label for="gambar_background" class="block text-gray-700 text-sm font-bold mb-2">Background Brand
                            (16:9 recommended)</label>
                        <input type="file" name="gambar_background" id="gambar_background"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Gambar latar belakang untuk kartu official store.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Simpan Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection