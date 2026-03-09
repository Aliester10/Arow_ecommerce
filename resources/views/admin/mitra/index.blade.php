@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Daftar Mitra
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Total: {{ $mitra->count() }} mitra
            </p>
        </div>
        <a href="{{ route('admin.mitra.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
            <i class="fas fa-plus mr-2"></i> Tambah Mitra
        </a>
    </div>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        @if(session('success'))
            <div
                class="flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
                <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399]">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3068 6.91894 10.979L15.2925 1.97485C15.6257 1.6091 15.6269 1.04057 15.2984 0.826822Z"
                            fill="white" stroke="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">
                        Sukses
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-gray-700">
                        <th class="min-w-[50px] py-4 px-4 font-medium text-black dark:text-white text-center">
                            No
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Logo
                        </th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                            Nama Mitra
                        </th>
                        <th class="min-w-[200px] py-4 px-4 font-medium text-black dark:text-white">
                            Website
                        </th>
                        <th class="min-w-[80px] py-4 px-4 font-medium text-black dark:text-white">
                            Urutan
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mitra as $index => $item)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                {{ $index + 1 }}
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div style="width: 80px; height: 80px;"
                                    class="rounded-md overflow-hidden flex items-center justify-center bg-gray-50 dark:bg-gray-700 border border-stroke dark:border-gray-600 flex-shrink-0">
                                    @if($item->logo)
                                        <img style="width: 80px; height: 80px; object-fit: contain;"
                                            src="{{ asset($item->logo) }}"
                                            alt="{{ $item->nama }}" />
                                    @else
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <h5 class="font-medium text-black dark:text-white">{{ $item->nama }}</h5>
                                @if($item->deskripsi)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($item->deskripsi, 50) }}</p>
                                @endif
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                @if($item->website)
                                    <a href="{{ $item->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        {{ $item->website }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p class="text-black dark:text-white">{{ $item->urutan }}</p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <p
                                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $item->aktif ? 'bg-success text-success' : 'bg-danger text-danger' }}">
                                    {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('admin.mitra.edit', $item->id) }}"
                                        class="hover:text-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.mitra.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada mitra ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
