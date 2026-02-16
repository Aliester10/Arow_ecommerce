@extends('layouts.admin')



@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Tambah Produk
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="flex flex-col gap-6">
            <!-- Live Preview -->
            @include('admin.products._product_preview')

            <!-- Form -->
            <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <div class="flex flex-col gap-9 sm:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Form Produk Baru
                        </h3>
                    </div>

                    @if(session('success'))
                        <div
                            class="m-6.5 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9">
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

                    @if($errors->any())
                        <div class="m-6.5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">Periksa kembali inputan anda.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Nama Produk <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Brand <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select name="id_brand" required
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="">Pilih Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id_brand }}" {{ old('id_brand') == $brand->id_brand ? 'selected' : '' }}>{{ $brand->nama_brand }}</option>
                                            @endforeach
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Kategori (Sub-Sub) <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select name="id_sub_subkategori" required
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($subSubkategoris as $sub)
                                                <option value="{{ $sub->id_sub_subkategori }}" {{ old('id_sub_subkategori') == $sub->id_sub_subkategori ? 'selected' : '' }}>
                                                    {{ $sub->subkategori->kategori->nama_kategori ?? 'Unknown' }} >
                                                    {{ $sub->subkategori->nama_subkategori ?? 'Unknown' }} >
                                                    {{ $sub->nama_sub_subkategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        SKU
                                    </label>
                                    <input type="text" name="sku_produk" value="{{ old('sku_produk') }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Tipe/Cover
                                    </label>
                                    <input type="text" name="tipe_produk" value="{{ old('tipe_produk') }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Asal Negara
                                    </label>
                                    <input type="text" name="asal_produk" value="{{ old('asal_produk') }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Dimensi
                                    </label>
                                    <input type="text" name="dimensi_produk" value="{{ old('dimensi_produk') }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Harga (Rp)
                                    </label>
                                    <input type="number" name="harga_produk" value="{{ old('harga_produk') }}" min="0"
                                        step="100" placeholder="0"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Stok <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="number" name="stok_produk" value="{{ old('stok_produk') }}" required
                                        min="0"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                                <div class="w-full xl:w-1/3">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Berat (Gram) <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="number" name="berat_produk" value="{{ old('berat_produk') }}" required
                                        min="0" step="0.01"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Deskripsi Produk <span class="text-meta-1">*</span>
                                </label>
                                <textarea name="deskripsi_produk" rows="6" required
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('deskripsi_produk') }}</textarea>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Gambar Produk <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="file" name="gambar_produk" required accept="image/*"
                                        class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Status <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select name="status_produk" required
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="aktif" {{ old('status_produk') == 'aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="nonaktif" {{ old('status_produk') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.8">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                                        fill=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection