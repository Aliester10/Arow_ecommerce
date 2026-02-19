@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Informasi Banner
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <div class="flex flex-col gap-9 sm:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                        <h3 class="font-medium text-black dark:text-white">
                            Form Edit Informasi Banner
                        </h3>
                    </div>

                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg mx-6.5 mt-6.5">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-green-500 mr-2"></i>
                            <div class="text-sm text-green-700">
                                <strong>Informasi Banner:</strong> Banner ini dapat diklik dan akan mengarah ke halaman informasi. 
                                Wajib mengisi link tujuan agar banner dapat berfungsi dengan baik.
                            </div>
                        </div>
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

                    <form action="{{ route('admin.promo-banners.update', $banner->id_promo_banner) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Informasi Banner Saat Ini
                                </label>
                                <div class="mb-4">
                                    @if(file_exists(public_path('storage/images/' . $banner->gambar_promo_banner)))
                                        <img src="{{ asset('storage/images/' . $banner->gambar_promo_banner) }}" alt="Current Informasi Banner"
                                            class="h-auto w-full rounded border border-stroke shadow-sm dark:border-gray-700">
                                    @else
                                        <div
                                            class="flex h-32 w-full items-center justify-center rounded border bg-gray-100 border-stroke dark:border-gray-700 dark:bg-gray-700">
                                            <span class="text-sm">No Image</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                    <div class="w-full xl:w-1/2 flex items-center pt-8">
                                        <label for="active" class="flex cursor-pointer select-none items-center">
                                            <div class="relative">
                                                <input type="checkbox" id="active" name="active" value="1" class="sr-only" {{ $banner->active ? 'checked' : '' }} />
                                                <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"></div>
                                                <div class="dot absolute left-1 top-1 h-6 w-6 rounded-full bg-white transition" {{ $banner->active ? 'style="transform: translateX(1.5rem); background-color: rgb(99, 102, 241);"' : '' }}></div>
                                            </div>
                                            <span class="ml-3 text-black dark:text-white">Aktif</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Pilih Detail Informasi (Opsional)
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select name="id_promo_detail"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="">-- Tidak ada detail informasi --</option>
                                            @foreach(App\Models\PromoDetail::get() as $promoDetail)
                                                <option value="{{ $promoDetail->id_promo_detail }}" {{ old('id_promo_detail', $banner->id_promo_detail) == $promoDetail->id_promo_detail ? 'selected' : '' }}>
                                                    {{ $promoDetail->judul_detail }}
                                                    @if($promoDetail->tanggal_mulai && $promoDetail->tanggal_selesai)
                                                        ({{ $promoDetail->tanggal_mulai->format('d/m/Y') }} - {{ $promoDetail->tanggal_selesai->format('d/m/Y') }})
                                                    @endif
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
                                    <p class="mt-1 text-xs text-body dark:text-bodydark">Pilih detail informasi yang akan ditampilkan saat banner diklik</p>
                                </div>

                                <div class="mb-4.5">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Ganti Gambar Informasi Banner
                                    </label>
                                    <input type="file" name="gambar_promo_banner" id="gambar_promo_banner" accept="image/*"
                                        class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                                    <p class="mt-1 text-xs text-body dark:text-bodydark">PNG, JPG, GIF up to 4MB</p>
                                </div>

                                <div id="image-preview" class="mb-4.5 hidden">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Preview Baru
                                    </label>
                                    <img src="" alt="Preview"
                                        class="h-auto w-full rounded border border-stroke dark:border-gray-700">
                                </div>

                                <button
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Update Informasi Banner
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Checkbox toggle functionality
        document.getElementById('active').addEventListener('change', function() {
            const dot = this.nextElementSibling.nextElementSibling;
            if (this.checked) {
                dot.style.transform = 'translateX(1.5rem)';
                dot.style.backgroundColor = 'rgb(99, 102, 241)';
            } else {
                dot.style.transform = 'translateX(0)';
                dot.style.backgroundColor = 'white';
            }
        });

        document.getElementById('gambar_promo_banner').addEventListener('change', function (e) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    img.src = event.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
@endsection
