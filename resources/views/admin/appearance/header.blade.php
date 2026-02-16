@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Pengaturan Header & Topbar
        </h2>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col gap-6">
        <!-- Live Preview (Desktop Mode) -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark flex justify-between items-center">
                <h3 class="font-medium text-black dark:text-white">
                    Live Preview (Desktop View)
                </h3>
                <span class="text-xs text-gray-500">
                    *Preview updates as you type
                </span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-boxdark-2 p-4 relative" style="height: 300px;">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
                    <span class="text-gray-400">Loading Preview...</span>
                </div>
                <iframe id="livePreviewFrame" src="{{ route('home') }}" frameborder="0"
                    class="w-full h-full bg-white relative z-10 shadow-sm" style="width: 100%;"></iframe>
            </div>
        </div>

        <!-- Editor Form -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Edit Informasi Header
                </h3>
            </div>
            <form action="{{ route('admin.appearance.header.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6.5">
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Nama Perusahaan (Navbar Text)
                        </label>
                        <input type="text" name="nama_perusahaan" id="input_nama_perusahaan"
                            value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Email (Topbar)
                        </label>
                        <input type="email" name="email_perusahaan" id="input_email_perusahaan"
                            value="{{ old('email_perusahaan', $perusahaan->email_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            No. Telepon (Topbar)
                        </label>
                        <input type="text" name="notelp_perusahaan" id="input_notelp_perusahaan"
                            value="{{ old('notelp_perusahaan', $perusahaan->notelp_perusahaan ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Logo Website
                        </label>
                        <input type="file" name="logo_perusahaan" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        <p class="text-sm text-gray-500 mt-2">
                            *Upload logo baru untuk melihat perubahan (Preview gambar belum didukung).
                        </p>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>

                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.appearance.footer') }}" class="text-sm text-primary hover:underline">
                            Ingin mengedit Footer? Ke Pengaturan Footer &rarr;
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const frame = document.getElementById('livePreviewFrame');

            // Wait for iframe to load
            frame.onload = function () {
                const doc = frame.contentDocument || frame.contentWindow.document;

                // Inject CSS to hide non-header elements
                const style = doc.createElement('style');
                style.textContent = `
                                #app-main, #app-footer { display: none !important; }
                                body { background-color: #f3f4f6; /* overflow: hidden; */ }
                                /* Force desktop-like width if needed, though surrounding container handles it */
                            `;
                doc.head.appendChild(style);

                // Elements to update in iframe
                const inputs = {
                    'input_nama_perusahaan': { selector: 'header a span.text-2xl', type: 'text' }, // Adjust selector based on actual app.blade.php
                    'input_email_perusahaan': { selector: '.fa-envelope + span', type: 'text' },
                    'input_notelp_perusahaan': { selector: '.fa-phone-alt + span', type: 'text' }
                };

                // Add event listeners to inputs
                Object.keys(inputs).forEach(inputId => {
                    const inputElement = document.getElementById(inputId);
                    if (inputElement) {
                        inputElement.addEventListener('input', function () {
                            const config = inputs[inputId];
                            // Find element in iframe
                            // Note: Selectors in app.blade.php might need to be more specific or data attributes added for robust selection
                            // For now, we try best guess selectors based on standard layouts
                            let target = null;

                            // Specific selection logic based on app.blade.php structure
                            if (inputId === 'input_nama_perusahaan') {
                                // Try finding text inside header logo area
                                const logoArea = doc.querySelector('header a.text-orange-600');
                                if (logoArea) target = logoArea.querySelector('span:last-child');
                            } else if (inputId === 'input_email_perusahaan') {
                                // Find element containing email icon parent's sibling span
                                const icons = doc.querySelectorAll('.fa-envelope');
                                icons.forEach(icon => {
                                    if (icon.nextElementSibling) target = icon.nextElementSibling;
                                    else if (icon.parentElement.nextElementSibling) target = icon.parentElement.nextElementSibling;
                                });
                            } else if (inputId === 'input_notelp_perusahaan') {
                                const icons = doc.querySelectorAll('.fa-phone-alt');
                                icons.forEach(icon => {
                                    if (icon.nextElementSibling) target = icon.nextElementSibling;
                                    else if (icon.parentElement.nextElementSibling) target = icon.parentElement.nextElementSibling;
                                });
                            }

                            if (target) {
                                target.innerText = this.value;
                            }
                        });
                    }
                });
            };
        });
    </script>
@endsection