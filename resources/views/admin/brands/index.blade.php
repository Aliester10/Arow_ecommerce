@extends('layouts.admin')



@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Manajemen Brand (Official Store)
        </h2>
        <a href="{{ route('admin.brands.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
            <i class="fas fa-plus mr-2"></i> Tambah Brand
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
                        <th class="min-w-[100px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            Logo
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Background
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Nama Brand
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-gray-700 xl:pl-11">
                                <div class="h-12.5 w-15 rounded-md">
                                    @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                        <img class="h-full w-full object-contain rounded-md border"
                                            src="{{ asset('storage/images/' . $brand->logo_brand) }}"
                                            alt="{{ $brand->nama_brand }}" />
                                    @else
                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center rounded-md">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="h-16 w-32 rounded-md">
                                    @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                        <img class="h-full w-full object-cover rounded-md border"
                                            src="{{ asset('storage/images/' . $brand->gambar_background) }}"
                                            alt="{{ $brand->nama_brand }} BG" />
                                    @else
                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center rounded-md">
                                            <span class="text-xs text-gray-400">No BG</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <h5 class="font-medium text-black dark:text-white">{{ $brand->nama_brand }}</h5>
                            </td>
                            <td class="border-b border-[#eee] py-5 px-4 dark:border-gray-700">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('admin.brands.edit', $brand->id_brand) }}" class="hover:text-primary"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id_brand) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus brand ini?');"
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
                            <td colspan="4" class="border-b border-[#eee] py-5 px-4 dark:border-gray-700 text-center">
                                Tidak ada brand ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4">
            {{ $brands->links() }}
        </div>
    </div>
@endsection