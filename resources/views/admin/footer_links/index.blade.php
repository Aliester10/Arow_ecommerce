@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Manajemen Link Footer
        </h2>
        <a href="{{ route('admin.footer_links.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
            <i class="fas fa-plus mr-2"></i> Tambah Link
        </a>
    </div>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        @if(session('success'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-gray-700">
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            Kelompok / Judul Kolom
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Label Link
                        </th>
                        <th class="min-w-[100px] py-4 px-4 font-medium text-black dark:text-white">
                            Type
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            URL
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Urutan
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($footerLinks as $link)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <p class="text-black dark:text-white font-medium">{{ $link->column_title }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $link->label }}</p>
                                @if($link->type === 'image' && $link->image_path)
                                    <img src="{{ asset('storage/footer_images/' . $link->image_path) }}" alt="{{ $link->label }}"
                                        class="h-8 mt-1 object-contain">
                                @endif
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <span
                                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $link->type === 'image' ? 'bg-success text-success' : 'bg-primary text-primary' }}">
                                    {{ ucfirst($link->type) }}
                                </span>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white text-sm">{{ $link->url }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $link->order }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('admin.footer_links.edit', $link->id_footer_link) }}"
                                        class="hover:text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.footer_links.destroy', $link->id_footer_link) }}"
                                        method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus link ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada link footer ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection