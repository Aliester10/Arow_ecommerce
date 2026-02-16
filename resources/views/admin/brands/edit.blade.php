@extends('layouts.admin')



@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Brand
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <div class="flex flex-col gap-9 sm:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Form Edit Brand
                        </h3>
                    </div>

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

                    <form action="{{ route('admin.brands.update', $brand->id_brand) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Nama Brand <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" name="nama_brand" value="{{ old('nama_brand', $brand->nama_brand) }}"
                                    required
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea name="deskripsi_brand" rows="3"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('deskripsi_brand', $brand->deskripsi_brand) }}</textarea>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Logo Brand
                                    </label>
                                    <div class="mb-3">
                                        @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                            <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" alt="Current Logo"
                                                class="h-24 w-24 rounded border object-contain border-stroke dark:border-gray-700">
                                        @else
                                            <div
                                                class="flex h-24 w-24 items-center justify-center rounded border bg-gray-100 border-stroke dark:border-gray-700 dark:bg-gray-700">
                                                <span class="text-sm">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="logo_brand" accept="image/*"
                                        class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                                    <p class="mt-1 text-xs text-body dark:text-bodydark">Kosongkan jika tidak ingin mengubah
                                        logo.</p>
                                </div>
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Background Brand
                                    </label>
                                    <div class="mb-3">
                                        @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                            <img src="{{ asset('storage/images/' . $brand->gambar_background) }}"
                                                alt="Current BG"
                                                class="h-24 w-full rounded border object-cover border-stroke dark:border-gray-700">
                                        @else
                                            <div
                                                class="flex h-24 w-full items-center justify-center rounded border bg-gray-100 border-stroke dark:border-gray-700 dark:bg-gray-700">
                                                <span class="text-sm">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="gambar_background" accept="image/*"
                                        class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                                    <p class="mt-1 text-xs text-body dark:text-bodydark">Kosongkan jika tidak ingin mengubah
                                        background.</p>
                                </div>
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Update Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection