@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Brand: {{ $brand->nama_brand }}
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <div class="grid grid-cols-1 gap-9">
            <div class="flex flex-col gap-9">
                <!-- Form Container -->
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

                    <form action="{{ route('admin.brands.update', $brand->id_brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6.5">
                            
                            <!-- GRID SECTION: Basic Info & Banner Preview -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                
                                <!-- Left Column: Basic Information -->
                                <div class="flex flex-col gap-4">
                                    <h4 class="font-semibold text-black dark:text-white text-base pb-1 border-b border-gray-100 dark:border-gray-700">
                                        Informasi Dasar
                                    </h4>

                                    <div>
                                        <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                            Nama Brand <span class="text-meta-1">*</span>
                                        </label>
                                        <input type="text" name="nama_brand" value="{{ old('nama_brand', $brand->nama_brand) }}" required
                                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                            Deskripsi (Opsional)
                                        </label>
                                        <textarea name="deskripsi_brand" rows="3" placeholder="Deskripsi singkat brand"
                                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('deskripsi_brand', $brand->deskripsi_brand) }}</textarea>
                                    </div>

                                    <!-- Current Logo and Background Preview -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                Logo Brand
                                            </label>
                                            <div class="mb-3">
                                                @if($brand->logo_brand && file_exists(public_path('storage/images/' . $brand->logo_brand)))
                                                    <img src="{{ asset('storage/images/' . $brand->logo_brand) }}" alt="Current Logo"
                                                        class="h-16 w-16 rounded border object-contain border-stroke dark:border-gray-700 bg-gray-50">
                                                @else
                                                    <div class="flex h-16 w-16 items-center justify-center rounded border bg-gray-100 border-stroke dark:border-gray-700 dark:bg-gray-700">
                                                        <span class="text-[10px]">No Logo</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="logo_brand" accept="image/*"
                                                class="w-full rounded border border-stroke p-2 text-xs outline-none transition file:mr-3 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2 file:text-xs file:font-medium focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                            <p class="mt-1 text-[11px] text-gray-400">Ganti logo brand.</p>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                Background Card (Default)
                                            </label>
                                            <div class="mb-3">
                                                @if($brand->gambar_background && file_exists(public_path('storage/images/' . $brand->gambar_background)))
                                                    <img src="{{ asset('storage/images/' . $brand->gambar_background) }}" alt="Current BG"
                                                        class="h-16 w-full rounded border object-cover border-stroke dark:border-gray-700 bg-gray-50">
                                                @else
                                                    <div class="flex h-16 w-full items-center justify-center rounded border bg-gray-100 border-stroke dark:border-gray-700 dark:bg-gray-700">
                                                        <span class="text-[10px]">No Image</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="gambar_background" accept="image/*"
                                                class="w-full rounded border border-stroke p-2 text-xs outline-none transition file:mr-3 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2 file:text-xs file:font-medium focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                            <p class="mt-1 text-[11px] text-gray-400">Ganti latar belakang kartu.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Showcase Banner & Overlay -->
                                <div class="flex flex-col gap-4">
                                    <h4 class="font-semibold text-black dark:text-white text-base pb-1 border-b border-gray-100 dark:border-gray-700">
                                        Showcase Banner & Overlay Settings
                                    </h4>

                                    <div>
                                        <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                            Banner Background Image
                                        </label>
                                        <input type="file" name="banner_image" id="banner_image_input" accept="image/*"
                                            class="w-full rounded border border-stroke p-2 text-xs outline-none transition file:mr-3 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2 file:text-xs file:font-medium focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                        <p class="mt-1 text-[11px] text-gray-400">Format: JPG, PNG, WEBP (Latar belakang banner besar)</p>
                                    </div>

                                    <!-- Live Preview Banner -->
                                    <div>
                                        <label class="mb-1 block text-xs font-semibold text-gray-400 uppercase">Preview Banner</label>
                                        <div id="banner_preview_container" class="relative w-full h-32 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center">
                                            <!-- Dynamic Overlay Tint -->
                                            <div id="banner_preview_overlay" class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(14, 165, 233, 0.7);"></div>
                                            
                                            <!-- Image -->
                                            @php
                                                $bannerExists = $brand->banner_image && file_exists(public_path('storage/images/' . $brand->banner_image));
                                            @endphp
                                            <img id="banner_preview_img" src="{{ $bannerExists ? asset('storage/images/' . $brand->banner_image) : '#' }}" alt="Banner Preview" 
                                                class="absolute inset-0 w-full h-full object-cover {{ $bannerExists ? '' : 'hidden' }}" />
                                            
                                            <div class="relative z-20 text-center p-3">
                                                <h5 id="banner_preview_title" class="text-white font-bold text-sm sm:text-base drop-shadow">{{ $brand->banner_title ?: $brand->nama_brand . ' OFFICIAL STORE' }}</h5>
                                                <p id="banner_preview_subtitle" class="text-white text-[10px] sm:text-xs opacity-90 leading-relaxed font-light line-clamp-1 drop-shadow">{{ $brand->banner_subtitle ?: 'Laptop & Accessories Premium' }}</p>
                                                <span id="banner_preview_btn" class="mt-2 inline-block px-3 py-1 bg-white text-gray-800 text-[10px] font-semibold rounded-full shadow-sm font-medium">{{ $brand->banner_button_text ?: 'Lihat Produk' }}</span>
                                            </div>
                                            <span id="banner_preview_placeholder" class="absolute z-0 text-xs text-gray-400 dark:text-gray-500 {{ $bannerExists ? 'hidden' : '' }}">Pilih banner untuk preview gambar</span>
                                        </div>
                                    </div>

                                    <!-- Overlay Settings -->
                                    <div class="flex gap-4">
                                        <div class="w-1/2">
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                Overlay Color
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="color" id="overlay_color_picker" value="{{ $brand->overlay_color ?: '#0EA5E9' }}" class="h-10 w-10 shrink-0 rounded border border-stroke cursor-pointer p-0 bg-transparent dark:border-gray-600" />
                                                <input type="text" name="overlay_color" id="overlay_color_hex" value="{{ $brand->overlay_color ?: '#0EA5E9' }}" placeholder="#0EA5E9" maxlength="7"
                                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2 px-3 text-sm font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                            </div>
                                        </div>
                                        <div class="w-1/2">
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                Overlay Opacity (<span id="opacity_val">{{ $brand->overlay_opacity !== null ? $brand->overlay_opacity : 70 }}</span>%)
                                            </label>
                                            <input type="range" name="overlay_opacity" id="overlay_opacity" min="0" max="100" value="{{ $brand->overlay_opacity !== null ? $brand->overlay_opacity : 70 }}"
                                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary mt-4 dark:bg-gray-700" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- GRID SECTION: Banner Content & Brand Statistics -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                
                                <!-- Left Column: Banner Content -->
                                <div class="flex flex-col gap-4">
                                    <h4 class="font-semibold text-black dark:text-white text-base pb-1 border-b border-gray-100 dark:border-gray-700">
                                        Banner Content Details
                                    </h4>

                                    <div>
                                        <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                            Judul Banner
                                        </label>
                                        <input type="text" name="banner_title" id="banner_title_input" value="{{ old('banner_title', $brand->banner_title) }}" placeholder="Contoh: ACER OFFICIAL"
                                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                            Subjudul Banner
                                        </label>
                                        <textarea name="banner_subtitle" id="banner_subtitle_input" rows="2" placeholder="Contoh: Laptop dan aksesoris terbaik untuk kebutuhan bisnis."
                                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">{{ old('banner_subtitle', $brand->banner_subtitle) }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                CTA Button Text
                                            </label>
                                            <input type="text" name="banner_button_text" id="banner_btn_text_input" value="{{ old('banner_button_text', $brand->banner_button_text ?: 'Lihat Produk') }}" placeholder="Lihat Produk"
                                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-black dark:text-white text-sm font-medium">
                                                CTA Button Link
                                            </label>
                                            <input type="text" name="banner_button_link" value="{{ old('banner_button_link', $brand->banner_button_link) }}" placeholder="/products?brand=1"
                                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Brand Statistics Settings -->
                                <div class="flex flex-col gap-4">
                                    <h4 class="font-semibold text-black dark:text-white text-base pb-1 border-b border-gray-100 dark:border-gray-700">
                                        Brand Statistics Display
                                    </h4>

                                    <div class="bg-gray-50 dark:bg-gray-700/50 p-5 rounded-xl border border-gray-100 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
                                            Pilih statistik apa saja yang ingin Anda tampilkan pada kartu showcase brand di halaman depan.
                                        </p>

                                        <div class="flex flex-col gap-4">
                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="show_product_count" value="1" {{ $brand->show_product_count ? 'checked' : '' }}
                                                    class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer transition-colors accent-primary" />
                                                <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-black dark:group-hover:text-white font-medium">
                                                    Tampilkan jumlah produk (Contoh: "120 Produk")
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="show_category_count" value="1" {{ $brand->show_category_count ? 'checked' : '' }}
                                                    class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer transition-colors accent-primary" />
                                                <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-black dark:group-hover:text-white font-medium">
                                                    Tampilkan jumlah kategori (Contoh: "5 Kategori")
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 cursor-pointer group">
                                                <input type="checkbox" name="show_official_badge" value="1" {{ $brand->show_official_badge ? 'checked' : '' }}
                                                    class="h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer transition-colors accent-primary" />
                                                <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-black dark:group-hover:text-white font-medium flex items-center gap-2">
                                                    Tampilkan badge Official 
                                                    <span class="bg-blue-500 text-white text-[9px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">Official</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3.5 font-semibold text-white hover:bg-opacity-90 shadow-md transition-all">
                                Update Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bannerInput = document.getElementById('banner_image_input');
    const previewImg = document.getElementById('banner_preview_img');
    const previewContainer = document.getElementById('banner_preview_container');
    const previewPlaceholder = document.getElementById('banner_preview_placeholder');
    
    const titleInput = document.getElementById('banner_title_input');
    const previewTitle = document.getElementById('banner_preview_title');
    const subtitleInput = document.getElementById('banner_subtitle_input');
    const previewSubtitle = document.getElementById('banner_preview_subtitle');
    const btnTextInput = document.getElementById('banner_btn_text_input');
    const previewBtn = document.getElementById('banner_preview_btn');

    const overlayPicker = document.getElementById('overlay_color_picker');
    const overlayHex = document.getElementById('overlay_color_hex');
    const overlayOpacityInput = document.getElementById('overlay_opacity');
    const opacityVal = document.getElementById('opacity_val');
    const previewOverlay = document.getElementById('banner_preview_overlay');

    // Handle File Input Preview
    bannerInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if (previewPlaceholder) previewPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Sync Text inputs
    const syncText = (input, preview, defaultText) => {
        const updateText = () => {
            preview.textContent = input.value.trim() || defaultText;
        };
        input.addEventListener('input', updateText);
        // Do not overwrite existing DB contents with default text at start
        if (input.value.trim()) {
            preview.textContent = input.value.trim();
        } else {
            preview.textContent = defaultText;
        }
    };

    syncText(titleInput, previewTitle, '{{ $brand->nama_brand }} OFFICIAL STORE');
    syncText(subtitleInput, previewSubtitle, 'Laptop & Accessories Premium');
    syncText(btnTextInput, previewBtn, 'Lihat Produk');

    // Sync Overlay styles
    const updateOverlayStyle = () => {
        const hex = overlayHex.value;
        const opacity = overlayOpacityInput.value;
        opacityVal.textContent = opacity;

        // Convert hex to rgb
        let cleanHex = hex.replace('#', '');
        let r = 14, g = 165, b = 233; // Fallback #0EA5E9
        if (cleanHex.length === 3) {
            r = parseInt(cleanHex.charAt(0) + cleanHex.charAt(0), 16);
            g = parseInt(cleanHex.charAt(1) + cleanHex.charAt(1), 16);
            b = parseInt(cleanHex.charAt(2) + cleanHex.charAt(2), 16);
        } else if (cleanHex.length === 6) {
            r = parseInt(cleanHex.substring(0, 2), 16);
            g = parseInt(cleanHex.substring(2, 4), 16);
            b = parseInt(cleanHex.substring(4, 6), 16);
        }

        previewOverlay.style.backgroundColor = `rgba(${r}, ${g}, ${b}, ${opacity / 100})`;
    };

    overlayPicker.addEventListener('input', function() {
        overlayHex.value = this.value.toUpperCase();
        updateOverlayStyle();
    });

    overlayHex.addEventListener('input', function() {
        let val = this.value;
        if (!val.startsWith('#') && val.trim().length > 0) {
            val = '#' + val;
            this.value = val;
        }
        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(val)) {
            overlayPicker.value = val;
            updateOverlayStyle();
        }
    });

    overlayOpacityInput.addEventListener('input', updateOverlayStyle);
    updateOverlayStyle();
});
</script>
@endpush