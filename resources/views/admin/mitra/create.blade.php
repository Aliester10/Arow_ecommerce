@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Tambah Mitra
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="flex flex-col gap-6 lg:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Form Mitra Baru
                        </h3>
                    </div>

                    @if($errors->any())
                        <div class="m-6.5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <ul class="mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mitra.store') }}" method="POST" enctype="multipart/form-data" class="p-6.5">
                        @csrf

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Nama Mitra <span class="text-meta-1">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                placeholder="Masukkan nama mitra" required>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Logo
                            </label>
                            <input type="file" name="logo"
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                accept="image/*">
                            <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF, SVG (Max: 2MB)</p>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                placeholder="Masukkan deskripsi mitra">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Website
                            </label>
                            <input type="url" name="website" value="{{ old('website') }}"
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                placeholder="https://example.com">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Urutan
                                </label>
                                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    placeholder="0">
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Status
                                </label>
                                <div class="flex items-center space-x-3 mt-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="aktif" value="1" {{ old('aktif') ? 'checked' : '' }}
                                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.mitra.index') }}"
                                class="inline-flex items-center justify-center rounded-md border border-stroke py-3 px-6 text-center font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Preview Logo
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <div id="logoPreview" class="flex items-center justify-center h-32 bg-gray-50 dark:bg-gray-700 rounded-lg border border-stroke dark:border-gray-600">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.querySelector('input[name="logo"]');
            const logoPreview = document.getElementById('logoPreview');

            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="max-h-full max-w-full object-contain">`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
