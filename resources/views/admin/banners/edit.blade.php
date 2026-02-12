@extends('layouts.admin')

@section('header_title', 'Edit Banner')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Banner</h1>
                <a href="{{ route('admin.banners.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
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

            <form action="{{ route('admin.banners.update', $banner->id_banner) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Banner Saat Ini</label>
                    <div class="mb-4">
                        @if(file_exists(public_path('storage/images/' . $banner->gambar_banner)))
                            <img src="{{ asset('storage/images/' . $banner->gambar_banner) }}" alt="Current Banner"
                                class="w-full h-auto rounded border shadow-sm">
                        @else
                            <div class="w-full h-32 bg-gray-100 flex items-center justify-center rounded border">
                                <i class="fas fa-image text-gray-300 text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <label for="gambar_banner" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar
                        Banner</label>
                    <input id="gambar_banner" name="gambar_banner" type="file"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 4MB</p>

                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-xs font-bold text-gray-700 mb-1">Preview Baru:</p>
                        <img src="" alt="Preview" class="w-full h-auto rounded border shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('gambar_banner').addEventListener('change', function (e) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    img.src = event.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
@endsection