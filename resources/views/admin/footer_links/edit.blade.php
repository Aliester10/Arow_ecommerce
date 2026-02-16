@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Link Footer
            </h2>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                <h3 class="font-medium text-black dark:text-white">
                    Form Edit Link
                </h3>
            </div>

            @if($errors->any())
                <div class="m-6.5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.footer_links.update', $footerLink->id_footer_link) }}" method="POST"
                enctype="multipart/form-data" x-data="{ type: '{{ $footerLink->type ?? 'text' }}' }">
                @csrf
                @method('PUT')
                <div class="p-6.5">
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Kelompok / Judul Kolom <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="column_title" value="{{ old('column_title', $footerLink->column_title) }}"
                            required placeholder="Contoh: Layanan Pelanggan" list="column_titles"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        <datalist id="column_titles">
                            <option value="Layanan Pelanggan">
                            <option value="Jelajahi">
                            <option value="Tentang Kami">
                            <option value="Pengiriman">
                        </datalist>
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Tipe Link <span class="text-meta-1">*</span>
                        </label>
                        <select name="type" x-model="type"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="text">Teks</option>
                            <option value="image">Gambar (Logo)</option>
                        </select>
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            <span x-text="type === 'image' ? 'Alt Text Gambar' : 'Label Link'">Label Link</span> <span
                                class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label', $footerLink->label) }}" required
                            :placeholder="type === 'image' ? 'Contoh: Logo JNE' : 'Contoh: Cara Belanja'"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5" x-show="type === 'image'">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Upload Gambar
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        @if($footerLink->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/footer_images/' . $footerLink->image_path) }}" alt="Current Image"
                                    class="h-10 object-contain">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            URL / Link Tujuan <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="url" value="{{ old('url', $footerLink->url) }}" required
                            placeholder="https://... atau /page (Gunakan # jika tidak ada link)"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Urutan (Order)
                        </label>
                        <input type="number" name="order" value="{{ old('order', $footerLink->order) }}" min="0"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <button
                        class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection