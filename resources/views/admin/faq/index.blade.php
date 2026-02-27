@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Manajemen FAQ
        </h2>
        <a href="{{ route('admin.faq.create') }}" 
           class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
            <i class="fas fa-plus mr-2"></i>
            Tambah FAQ
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
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Pertanyaan</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Jawaban</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Urutan</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $index => $faq)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ Str::limit($faq->pertanyaan, 100) }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                    {{ Str::limit(strip_tags($faq->jawaban), 150) }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ $faq->urutan }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $faq->is_active ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                        {{ $faq->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('admin.faq.edit', $faq) }}" 
                                           class="inline-flex items-center justify-center rounded bg-blue-600 hover:bg-blue-700 px-2 py-1 text-xs font-medium text-white transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.faq.toggle-status', $faq) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center rounded {{ $faq->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} px-2 py-1 text-xs font-medium text-white transition-colors duration-200"
                                                    title="{{ $faq->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $faq->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.faq.destroy', $faq) }}" 
                                              method="POST" class="inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center rounded bg-red-600 hover:bg-red-700 px-2 py-1 text-xs font-medium text-white transition-colors duration-200">
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
                                        <i class="fas fa-question-circle fa-4x text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada data FAQ</p>
                                        <a href="{{ route('admin.faq.create') }}" 
                                           class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah FAQ Pertama
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
