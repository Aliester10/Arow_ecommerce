@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Pengaturan Footer
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
                    Live Preview (Footer Area)
                </h3>
                <span class="text-xs text-gray-500">
                    *Preview updates as you type
                </span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-boxdark-2 p-4 relative" style="height: 400px;">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
                    <span class="text-gray-400">Loading Preview...</span>
                </div>
                <iframe id="livePreviewFrameFooter" src="{{ route('home') }}" frameborder="0"
                    class="w-full h-full bg-white relative z-10 shadow-sm" style="width: 100%;"></iframe>
            </div>
        </div>

        <!-- Editor Form -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Edit Informasi Footer
                </h3>
            </div>
            <form action="{{ route('admin.appearance.footer.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6.5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4.5">
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">
                                Alamat
                            </label>
                            <textarea rows="3" name="alamat_perusahaan" id="input_alamat_perusahaan"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('alamat_perusahaan', $perusahaan->alamat_perusahaan ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">
                                Deskripsi Singkat (Footer)
                            </label>
                            <textarea rows="3" name="footer_description" id="input_footer_description"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('footer_description', $perusahaan->footer_description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4.5">
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">
                                No. Telepon (Footer)
                            </label>
                            <input type="text" name="notelp_perusahaan" id="input_notelp_perusahaan"
                                value="{{ old('notelp_perusahaan', $perusahaan->notelp_perusahaan ?? '') }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        </div>
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">
                                Email (Footer)
                            </label>
                            <input type="email" name="email_perusahaan" id="input_email_perusahaan"
                                value="{{ old('email_perusahaan', $perusahaan->email_perusahaan ?? '') }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Member Of Image (Logo Bawah)
                        </label>
                        <input type="file" name="member_of_image" accept="image/*"
                            class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white" />
                        @if($perusahaan->member_of_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/images/' . $perusahaan->member_of_image) }}" alt="Member Of"
                                    class="h-10 object-contain">
                            </div>
                        @endif
                    </div>


                </div>


                <h4 class="mb-4 text-lg font-bold text-black dark:text-white mt-8">Logistick Partners / Pengiriman</h4>
                <p class="mb-4 text-sm text-gray-500">
                    Kelola link dan logo ekspedisi pengiriman (Contoh: JNE, TIKI).
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4.5 bg-gray-50 dark:bg-gray-700 p-4 rounded">
                    @foreach($shippingLinks as $link)
                        <div class="border-b last:border-b-0 pb-4 last:pb-0 md:border-b-0">
                            <label class="mb-2 block text-sm font-bold text-black dark:text-white">
                                {{ $link->label }}
                            </label>
                            <input type="hidden" name="shipping_links[{{ $link->id_footer_link }}][id]"
                                value="{{ $link->id_footer_link }}">

                            <div class="mb-3">
                                <label class="mb-1 block text-xs">URL</label>
                                <input type="text" name="shipping_links[{{ $link->id_footer_link }}][url]"
                                    value="{{ old("shipping_links.{$link->id_footer_link}.url", $link->url) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-white py-2 px-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-sm" />
                            </div>

                            <div>
                                <label class="mb-1 block text-xs">Logo (Upload Baru untuk Mengganti)</label>
                                <input type="file" name="shipping_links[{{ $link->id_footer_link }}][image]" accept="image/*"
                                    class="w-full rounded-md border border-stroke p-2 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2 file:text-xs file:font-medium focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white text-sm" />
                                @if($link->image_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/footer_images/' . $link->image_path) }}"
                                            alt="{{ $link->label }}"
                                            class="h-8 object-contain bg-white dark:bg-white/90 p-1 rounded border dark:border-strokedark">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if($shippingLinks->isEmpty())
                        <div class="col-span-2 text-center text-sm text-gray-500 py-4">
                            Belum ada data pengiriman. Silakan tambahkan 'PENGIRIMAN' di menu "Kelola Link Footer" jika ingin
                            menambah ekspedisi baru.
                        </div>
                    @endif
                </div>

                <h4 class="mb-4 text-lg font-bold text-black dark:text-white mt-8">Social Media</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4.5">
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-facebook mr-2"></i>
                            FB</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $perusahaan->facebook ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-instagram mr-2"></i>
                            IG</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $perusahaan->instagram ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-twitter mr-2"></i>
                            X</label>
                        <input type="text" name="twitter" value="{{ old('twitter', $perusahaan->twitter ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-tiktok mr-2"></i>
                            TT</label>
                        <input type="text" name="tiktok" value="{{ old('tiktok', $perusahaan->tiktok ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white"><i class="fab fa-youtube mr-2"></i>
                            YT</label>
                        <input type="text" name="youtube" value="{{ old('youtube', $perusahaan->youtube ?? '') }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <button type="submit"
                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                    Simpan Footer
                </button>

                <a href="{{ route('admin.footer_links.index') }}"
                    class="flex w-full justify-center rounded bg-secondary p-3 mt-3 font-medium text-white hover:bg-opacity-90">
                    Kelola Links Footer
                </a>
        </div>
        </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const frame = document.getElementById('livePreviewFrameFooter');

            // Wait for iframe to load and scroll to bottom
            frame.onload = function () {
                const win = frame.contentWindow;
                const doc = frame.contentWindow.document;

                // Inject CSS to hide non-footer elements
                const style = doc.createElement('style');
                style.textContent = `
                                            #app-topbar, #app-header, #app-main { display: none !important; }
                                            body { background-color: #f3f4f6; }
                                        `;
                doc.head.appendChild(style);

                // Scroll to top since everything else is hidden, footer should be at top
                win.scrollTo(0, 0);

                // Elements to update in iframe
                const inputs = {
                    'input_alamat_perusahaan': { selector: 'footer .w-4\\/12 p:first-of-type', type: 'text' },
                    'input_footer_description': { selector: 'footer .w-4\\/12 p:nth-of-type(2)', type: 'text' },
                    'input_notelp_perusahaan': { selector: 'footer .fa-phone-alt', type: 'icon-parent-text' },
                    'input_email_perusahaan': { selector: 'footer .fa-envelope', type: 'icon-parent-text' }
                };

                // Add event listeners to inputs
                Object.keys(inputs).forEach(inputId => {
                    const inputElement = document.getElementById(inputId);
                    if (inputElement) {
                        inputElement.addEventListener('input', function () {
                            const config = inputs[inputId];
                            let target = null;

                            // Find element in iframe
                            let el = doc.querySelector(config.selector);

                            if (config.type === 'text') {
                                // Special handling for nth-of-type selector which querySelector might struggle with if not careful
                                if (inputId === 'input_alamat_perusahaan') {
                                    // 1st p inside the first column
                                    const col = doc.querySelector('footer .w-full.lg\\:w-4\\/12');
                                    if (col) target = col.querySelector('p');
                                } else if (inputId === 'input_footer_description') {
                                    // 2nd p inside the first column
                                    const col = doc.querySelector('footer .w-full.lg\\:w-4\\/12');
                                    if (col) target = col.querySelectorAll('p')[1];
                                }

                                if (target) target.innerText = this.value;

                            } else if (config.type === 'icon-parent-text') {
                                if (el) {
                                    // el is the icon. we need the span next to it.
                                    // Structure: div > icon, span
                                    // OR div > div > icon ... span
                                    // Let's find the closest row container
                                    const row = el.closest('.flex');
                                    if (row) {
                                        target = row.querySelector('span');
                                        if (target) target.innerText = this.value;
                                    }
                                }
                            }
                        });
                    }
                });
            };
        });
    </script>
@endsection