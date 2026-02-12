@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Manajemen Brand (Official Store)</h1>
                <a href="{{ route('admin.brands.create') }}"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Tambah Brand
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Logo
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Background
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Brand
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex-shrink-0 w-16 h-16">
                                        @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                            <img class="w-full h-full object-contain rounded border"
                                                src="{{ asset('storage/images/' . $brand->logo_brand) }}"
                                                alt="{{ $brand->nama_brand }}" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex-shrink-0 w-32 h-16">
                                        @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                            <img class="w-full h-full object-cover rounded border"
                                                src="{{ asset('storage/images/' . $brand->gambar_background) }}"
                                                alt="{{ $brand->nama_brand }} BG" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                                                <span class="text-xs text-gray-400">No BG</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-medium">{{ $brand->nama_brand }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.brands.edit', $brand->id_brand) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id_brand) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus brand ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    Tidak ada brand ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
@endsection