@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Kelola Kategori
    </h2>
    <a href="{{ route('admin.categories.create') }}" 
       class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600">
        <i class="fas fa-plus mr-2"></i>
        Tambah Kategori
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700">
    <div class="px-6 py-4 border-b border-stroke dark:border-gray-700">
        <h3 class="text-lg font-semibold text-black dark:text-white">Daftar Kategori</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Nama Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Logo Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $category->nama_kategori }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($category->icon_kategori && file_exists(public_path('storage/images/' . $category->icon_kategori)))
                                    <img src="{{ asset('storage/images/' . $category->icon_kategori) }}" 
                                         alt="{{ $category->nama_kategori }}" 
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-lg"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="text-brand-500 hover:text-brand-600 mr-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete({{ $category->id_kategori }})" 
                                    class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-2"></i>
                            <p>Belum ada kategori</p>
                            <a href="{{ route('admin.categories.create') }}" class="text-brand-500 hover:text-brand-600">
                                Tambah kategori pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="delete-form" method="POST" action="{{ route('admin.categories.destroy', ':id') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        const form = document.getElementById('delete-form');
        form.action = form.action.replace(':id', id);
        form.submit();
    }
}
</script>
@endsection
