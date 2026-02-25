@extends('layouts.admin')

@section('title', 'Kelola Sub Kategori')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Kelola Sub Kategori
    </h2>
    <a href="{{ route('admin.sub-categories.create') }}" 
       class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600">
        <i class="fas fa-plus mr-2"></i>
        Tambah Sub Kategori
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700">
    <div class="px-6 py-4 border-b border-stroke dark:border-gray-700">
        <h3 class="text-lg font-semibold text-black dark:text-white">Daftar Sub Kategori</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Nama Sub Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Kategori Induk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Sub Sub Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($subCategories as $subCategory)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $subCategory->nama_subkategori }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $subCategory->category?->nama_kategori ?? 'Tidak ada kategori' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $subCategory->subSubCategories?->count() ?? 0 }} sub sub kategori
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.sub-categories.edit', $subCategory) }}" 
                               class="text-brand-500 hover:text-brand-600 mr-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete({{ $subCategory->id_subkategori }})" 
                                    class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-2"></i>
                            <p>Belum ada sub kategori</p>
                            <a href="{{ route('admin.sub-categories.create') }}" class="text-brand-500 hover:text-brand-600">
                                Tambah sub kategori pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="delete-form" method="POST" action="{{ route('admin.sub-categories.destroy', ':id') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus sub kategori ini?')) {
        const form = document.getElementById('delete-form');
        form.action = form.action.replace(':id', id);
        form.submit();
    }
}
</script>
@endsection
