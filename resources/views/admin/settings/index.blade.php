@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Pengaturan Website
        </h2>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
        <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
            <h3 class="font-medium text-black dark:text-white">
                Informasi & Konfigurasi Umum
            </h3>
        </div>
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6.5">

                <!-- General Info -->
                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Nama Perusahaan <span
                                class="text-meta-1">*</span></label>
                        <input type="text" name="nama_perusahaan"
                            value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Website URL</label>
                        <input type="text" name="website_perusahaan"
                            value="{{ old('website_perusahaan', $perusahaan->website_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">Alamat Lengkap</label>
                    <textarea rows="3" name="alamat_perusahaan"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('alamat_perusahaan', $perusahaan->alamat_perusahaan ?? '') }}</textarea>
                </div>

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Email Utama</label>
                        <input type="email" name="email_perusahaan"
                            value="{{ old('email_perusahaan', $perusahaan->email_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Email Sales (Opsional)</label>
                        <input type="email" name="email_sales"
                            value="{{ old('email_sales', $perusahaan->email_sales ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">No. Telepon Utama</label>
                        <input type="text" name="notelp_perusahaan"
                            value="{{ old('notelp_perusahaan', $perusahaan->notelp_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">No. Telepon Alternatif</label>
                        <input type="text" name="phone_alt" value="{{ old('phone_alt', $perusahaan->phone_alt ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <!-- Footer Description -->
                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">Deskripsi Footer</label>
                    <textarea rows="4" name="footer_description"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('footer_description', $perusahaan->footer_description ?? '') }}</textarea>
                </div>

                <!-- Social Media -->
                <h4 class="mb-4 text-lg font-bold text-black dark:text-white mt-8">Social Media Links</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4.5">
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-facebook mr-2"></i>
                            Facebook</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $perusahaan->facebook ?? '') }}"
                            placeholder="https://facebook.com/..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-instagram mr-2"></i>
                            Instagram</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $perusahaan->instagram ?? '') }}"
                            placeholder="https://instagram.com/..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-twitter mr-2"></i> Twitter /
                            X</label>
                        <input type="text" name="twitter" value="{{ old('twitter', $perusahaan->twitter ?? '') }}"
                            placeholder="https://twitter.com/..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-linkedin mr-2"></i>
                            LinkedIn</label>
                        <input type="text" name="linkedin" value="{{ old('linkedin', $perusahaan->linkedin ?? '') }}"
                            placeholder="https://linkedin.com/in/..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-tiktok mr-2"></i>
                            TikTok</label>
                        <input type="text" name="tiktok" value="{{ old('tiktok', $perusahaan->tiktok ?? '') }}"
                            placeholder="https://tiktok.com/@..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <!-- Images -->
                <h4 class="mb-4 text-lg font-bold text-black dark:text-white mt-8">Gambar Perusahaan</h4>
                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Logo Website</label>
                        <input type="file" name="logo_perusahaan" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        @if ($perusahaan && $perusahaan->logo_perusahaan)
                            <div class="mt-2">
                                <img src="{{ asset('storage/images/' . $perusahaan->logo_perusahaan) }}" alt="Current Logo"
                                    class="h-20 object-contain">
                            </div>
                        @endif
                    </div>
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">Logo 'Member Of' (Footer)</label>
                        <input type="file" name="member_of_image" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        @if ($perusahaan && $perusahaan->member_of_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/images/' . $perusahaan->member_of_image) }}" alt="Current Member Of"
                                    class="h-20 object-contain">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end gap-4.5 mt-8">
                    <button type="submit"
                        class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection