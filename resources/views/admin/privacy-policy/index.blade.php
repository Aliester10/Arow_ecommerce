@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Manajemen Kebijakan Privasi
        </h2>
        <a href="{{ route('admin.privacy-policy.create') }}" 
           class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
            <i class="fas fa-plus mr-2"></i>
            Tambah Kebijakan Privasi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800 dark:bg-green-900/20 dark:text-green-200">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
        <div class="p-4 md:p-6 xl:p-7.5">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left dark:bg-gray-800">
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">No</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Judul</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Subjudul</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Terakhir Diperbarui</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($privacyPolicies as $index => $privacyPolicy)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $privacyPolicy->title }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $privacyPolicy->subtitle }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ $privacyPolicy->last_updated->format('d F Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $privacyPolicy->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                        {{ $privacyPolicy->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('admin.privacy-policy.edit', $privacyPolicy) }}" 
                                           class="inline-flex items-center justify-center rounded bg-blue-600 hover:bg-blue-700 px-2 py-1 text-xs font-medium text-white transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.privacy-policy.toggle-status', $privacyPolicy) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center rounded {{ $privacyPolicy->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} px-2 py-1 text-xs font-medium text-white transition-colors duration-200"
                                                    title="{{ $privacyPolicy->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $privacyPolicy->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.privacy-policy.destroy', $privacyPolicy) }}" 
                                              method="POST" class="inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kebijakan privasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center rounded bg-red-600 hover:bg-red-700 px-2 py-1 text-xs font-medium text-white transition-colors duration-200"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-shield-alt fa-4x text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada data Kebijakan Privasi</p>
                                        <a href="{{ route('admin.privacy-policy.create') }}" 
                                           class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Kebijakan Privasi Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
