@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10" x-data="brandSettings()">
    <!-- Breadcrumb Start -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Brand Settings
        </h2>
    </div>
    <!-- Breadcrumb End -->

    @if(session('success'))
        <div class="flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-6 rounded-sm">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399] shrink-0">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3068 6.91894 10.979L15.2925 1.97485C15.6257 1.6091 15.6269 1.04057 15.2984 0.826822Z" fill="white" stroke="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-1 text-lg font-bold text-black dark:text-[#34D399]">
                    Sukses
                </h5>
                <p class="text-base text-body dark:text-bodydark">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left: Brand List Sidebar -->
        <div class="w-full lg:w-1/3 shrink-0 flex flex-col gap-6">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800 p-5">
                <h3 class="font-semibold text-black dark:text-white mb-4 pb-2 border-b border-stroke dark:border-gray-700 flex items-center justify-between">
                    <span>Pilih Brand</span>
                    <span class="text-xs bg-primary/10 text-primary px-2.5 py-1 rounded-full font-medium" x-text="brands.length + ' Brands'"></span>
                </h3>

                <!-- In House Brands Section -->
                <div class="mb-6">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-3">Our In-House Brands</span>
                    <div class="flex flex-col gap-2.5">
                        <template x-for="brand in inHouseBrands" :key="brand.id_brand">
                            <button @click="selectBrand(brand)" 
                                    class="flex items-center gap-3.5 p-3 rounded-xl border text-left transition-all duration-300 w-full hover:scale-[1.02]"
                                    :class="selectedBrandId == brand.id_brand 
                                        ? 'border-primary bg-primary/5 text-primary shadow-sm' 
                                        : 'border-stroke dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 text-gray-700 dark:text-gray-300'">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-1 border border-stroke dark:border-gray-600 shrink-0">
                                    <template x-if="brand.logo_brand">
                                        <img :src="'/storage/images/' + brand.logo_brand" :alt="brand.nama_brand" class="max-w-full max-h-full object-contain">
                                    </template>
                                    <template x-if="!brand.logo_brand">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </template>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-semibold text-sm truncate" x-text="brand.nama_brand"></h4>
                                    <p class="text-xs text-gray-400 truncate" x-text="brand.overlay_color || '#B7E3F6'"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Other Brands Section -->
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-3">Other Brands</span>
                    <div class="flex flex-col gap-2.5 max-h-[300px] overflow-y-auto pr-1">
                        <template x-for="brand in otherBrands" :key="brand.id_brand">
                            <button @click="selectBrand(brand)" 
                                    class="flex items-center gap-3.5 p-3 rounded-xl border text-left transition-all duration-300 w-full hover:scale-[1.02]"
                                    :class="selectedBrandId == brand.id_brand 
                                        ? 'border-primary bg-primary/5 text-primary shadow-sm' 
                                        : 'border-stroke dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 text-gray-700 dark:text-gray-300'">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-1 border border-stroke dark:border-gray-600 shrink-0">
                                    <template x-if="brand.logo_brand">
                                        <img :src="'/storage/images/' + brand.logo_brand" :alt="brand.nama_brand" class="max-w-full max-h-full object-contain">
                                    </template>
                                    <template x-if="!brand.logo_brand">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </template>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-semibold text-sm truncate" x-text="brand.nama_brand"></h4>
                                    <p class="text-xs text-gray-400 truncate" x-text="brand.overlay_color || '#B7E3F6'"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Editor & Live Preview Panel -->
        <div class="flex-1 flex flex-col gap-6" x-show="selectedBrand">
            
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                <!-- Header -->
                <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-black dark:text-white" x-text="'Pengaturan Warna: ' + selectedBrand.nama_brand"></h3>
                        <p class="text-xs text-gray-400 mt-1">Konfigurasi background overlay secara real-time</p>
                    </div>
                    
                    <!-- Auto Save Status Indicator -->
                    <div class="flex items-center gap-2">
                        <template x-if="saveStatus === 'saving'">
                            <span class="inline-flex items-center gap-1.5 text-xs text-yellow-500 bg-yellow-500/10 px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                            </span>
                        </template>
                        <template x-if="saveStatus === 'saved'">
                            <span class="inline-flex items-center gap-1.5 text-xs text-green-500 bg-green-500/10 px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-check-circle"></i> Tersimpan Otomatis
                            </span>
                        </template>
                        <template x-if="saveStatus === 'error'">
                            <span class="inline-flex items-center gap-1.5 text-xs text-red-500 bg-red-500/10 px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-exclamation-circle"></i> Gagal Menyimpan
                            </span>
                        </template>
                        <template x-if="saveStatus === 'idle'">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full font-medium">
                                Siap
                            </span>
                        </template>
                    </div>
                </div>

                <div class="p-6.5 flex flex-col md:flex-row gap-8">
                    <!-- Form Editor -->
                    <div class="flex-1 flex flex-col gap-6">
                        <form :action="'{{ route('admin.brands.settings.update') }}'" method="POST" @submit="onSubmitForm">
                            @csrf
                            <input type="hidden" name="id_brand" :value="selectedBrand.id_brand">

                            <!-- Brand Name (Readonly) -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white font-medium text-sm">
                                    Brand Name (Readonly)
                                </label>
                                <input type="text" :value="selectedBrand.nama_brand" readonly
                                    class="w-full rounded border-[1.5px] border-stroke bg-gray-50 dark:bg-gray-700/50 py-3 px-5 font-medium outline-none text-gray-500 cursor-not-allowed dark:border-form-strokedark" />
                            </div>

                            <!-- Color Picker and manual HEX -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white font-medium text-sm">
                                    Overlay Color
                                </label>
                                <div class="flex gap-3">
                                    <!-- Color Picker Indicator -->
                                    <div class="w-12 h-12 rounded border border-stroke dark:border-gray-600 overflow-hidden shrink-0 relative cursor-pointer">
                                        <input type="color" x-model="overlayColor" @input="onColorInput"
                                            class="absolute inset-[-6px] w-[200%] h-[200%] cursor-pointer border-none p-0 bg-transparent">
                                    </div>
                                    
                                    <!-- Manual Hex Input -->
                                    <div class="relative flex-grow">
                                        <input type="text" name="overlay_color" x-model="overlayColorInput" @input="onHexInput"
                                            maxlength="7"
                                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            placeholder="#FFFFFF" />
                                        
                                        <!-- Copy Color Code Trigger -->
                                        <button type="button" @click="copyColorCode"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors py-1 px-2"
                                            title="Copy Color Code">
                                            <i class="far" :class="copied ? 'fa-check-circle text-green-500' : 'fa-copy'"></i>
                                            <span class="text-xs ml-1" x-text="copied ? 'Copied' : 'Copy'"></span>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-[11px] text-red-500 mt-1" x-show="hexError" x-text="hexError"></p>
                            </div>

                            <!-- Opacity Slider -->
                            <div class="mb-5.5">
                                <div class="flex justify-between items-center mb-2.5">
                                    <label class="text-black dark:text-white font-medium text-sm">
                                        Overlay Opacity
                                    </label>
                                    <span class="text-xs bg-primary/10 text-primary px-2.5 py-1 rounded font-bold" x-text="overlayOpacity + '%'"></span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs text-gray-400 font-medium">0%</span>
                                    <input type="range" name="overlay_opacity" min="0" max="100" x-model="overlayOpacity" @input="onOpacityInput"
                                        class="flex-grow h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary dark:bg-gray-700">
                                    <span class="text-xs text-gray-400 font-medium">100%</span>
                                </div>
                            </div>

                            <!-- Preset Colors -->
                            <div class="mb-6">
                                <label class="mb-2.5 block text-black dark:text-white font-medium text-xs uppercase tracking-wider text-gray-400">
                                    Preset Colors
                                </label>
                                <div class="flex flex-wrap gap-2.5">
                                    <template x-for="preset in presets" :key="preset">
                                        <button type="button" @click="applyPreset(preset)"
                                            class="w-8 h-8 rounded-full border border-stroke dark:border-gray-600 transition-all duration-300 hover:scale-110 relative"
                                            :style="'background-color: ' + preset"
                                            :title="preset">
                                            <span x-show="overlayColor.toLowerCase() === preset.toLowerCase()"
                                                class="absolute inset-0 flex items-center justify-center text-[10px] text-gray-700 font-bold bg-white/20 rounded-full">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Actions Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 mt-8">
                                <button type="submit" 
                                    class="flex-1 flex justify-center rounded bg-primary p-3 font-semibold text-white hover:bg-opacity-95 transition-all shadow-md">
                                    Save Changes
                                </button>
                                <button type="button" @click="resetToDefault"
                                    class="flex-1 flex justify-center rounded border border-stroke dark:border-gray-700 p-3 font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    Reset to Default
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Live Preview Card Column -->
                    <div class="w-full md:w-[320px] shrink-0 flex flex-col">
                        <label class="mb-2.5 block text-black dark:text-white font-medium text-sm">
                            Live Preview Card
                        </label>
                        
                        <!-- Simulating the homepage brand card -->
                        <div class="w-full relative shadow-xl p-6 flex flex-col justify-between overflow-hidden min-h-[380px]"
                             :style="'background: ' + previewBackgroundStyle + '; border-radius: 30px !important; transition: background 0.3s ease;'">
                            
                            <!-- Background Image Overlay -->
                            <div class="absolute inset-0 z-0 pointer-events-none">
                                <template x-if="selectedBrand.gambar_background">
                                    <img :src="'/storage/images/' + selectedBrand.gambar_background" 
                                         alt="Background" 
                                         class="w-full h-full object-cover"
                                         style="opacity: 0.11;">
                                </template>
                                <template x-if="!selectedBrand.gambar_background">
                                    <div class="w-full h-full bg-gradient-to-tr from-black/5 to-white/5 opacity-40"></div>
                                </template>
                            </div>

                            <!-- Decorative overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none z-0"></div>

                            <!-- Content -->
                            <div class="relative z-10 text-center flex flex-col justify-center items-center h-full">
                                <!-- Logo -->
                                <div class="h-14 flex items-center justify-center mb-4">
                                    <template x-if="selectedBrand.logo_brand">
                                        <img :src="'/storage/images/' + selectedBrand.logo_brand" 
                                             alt="Logo" 
                                             class="max-h-full object-contain">
                                    </template>
                                    <template x-if="!selectedBrand.logo_brand">
                                        <span class="text-white font-extrabold text-lg tracking-wider" x-text="selectedBrand.nama_brand.toUpperCase()"></span>
                                    </template>
                                </div>

                                <!-- Description -->
                                <p class="text-white text-xs mb-6 opacity-90 leading-relaxed font-light">
                                    Our trusted in-house brand, built for quality and performance
                                </p>

                                <!-- See All Button -->
                                <a href="javascript:void(0)" 
                                   class="inline-flex items-center justify-center px-6 py-2.5 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold rounded-full shadow-md">
                                    <span>See All</span>
                                    <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                                </a>
                            </div>

                            <!-- Skeleton Product Cards Mock -->
                            <div class="relative z-10 grid grid-cols-2 gap-2 mt-auto">
                                <div class="bg-white rounded-lg p-2 flex flex-col gap-1.5 opacity-90">
                                    <div class="bg-gray-200 aspect-square rounded w-full"></div>
                                    <div class="h-2.5 bg-gray-200 rounded w-4/5"></div>
                                    <div class="h-3 bg-[#eab308]/20 rounded w-3/5"></div>
                                </div>
                                <div class="bg-white rounded-lg p-2 flex flex-col gap-1.5 opacity-90">
                                    <div class="bg-gray-200 aspect-square rounded w-full"></div>
                                    <div class="h-2.5 bg-gray-200 rounded w-3/5"></div>
                                    <div class="h-3 bg-[#eab308]/20 rounded w-2/5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    function brandSettings() {
        return {
            brands: @json($brands),
            inHouseBrands: @json($inHouseBrands->values()),
            otherBrands: @json($otherBrands->values()),
            selectedBrandId: null,
            selectedBrand: null,
            
            // Current input states
            overlayColor: '#B7E3F6',
            overlayColorInput: '#B7E3F6',
            overlayOpacity: 70,
            
            // Errors
            hexError: '',
            copied: false,
            
            // Statuses
            saveStatus: 'idle', // idle, saving, saved, error
            autoSaveTimeout: null,
            
            // Constants
            presets: ["#B7E3F6", "#D7E6D0", "#FFE5B4", "#FADADD", "#E6E6FA", "#F5F5DC"],
            defaultColor: '#B7E3F6',
            defaultOpacity: 70,
            
            init() {
                // Select first brand in inHouse list if exists, otherwise first overall
                if (this.inHouseBrands.length > 0) {
                    this.selectBrand(this.inHouseBrands[0]);
                } else if (this.brands.length > 0) {
                    this.selectBrand(this.brands[0]);
                }
            },
            
            selectBrand(brand) {
                // Cancel any pending auto-saves
                if (this.autoSaveTimeout) {
                    clearTimeout(this.autoSaveTimeout);
                }
                
                this.selectedBrandId = brand.id_brand;
                this.selectedBrand = brand;
                
                // Set state values
                this.overlayColor = brand.overlay_color || this.defaultColor;
                this.overlayColorInput = this.overlayColor;
                this.overlayOpacity = brand.overlay_opacity !== null ? brand.overlay_opacity : this.defaultOpacity;
                
                this.hexError = '';
                this.saveStatus = 'idle';
                this.copied = false;
            },
            
            get previewBackgroundStyle() {
                const hex = this.overlayColor;
                const opacity = this.overlayOpacity;
                const rgba = this.hexToRgba(hex, opacity);
                return `linear-gradient(${rgba}, ${rgba})`;
            },
            
            hexToRgba(hex, opacity) {
                hex = hex.replace('#', '');
                let r, g, b;
                if (hex.length === 3) {
                    r = parseInt(hex.charAt(0) + hex.charAt(0), 16);
                    g = parseInt(hex.charAt(1) + hex.charAt(1), 16);
                    b = parseInt(hex.charAt(2) + hex.charAt(2), 16);
                } else {
                    r = parseInt(hex.substring(0, 2) || '0', 16);
                    g = parseInt(hex.substring(2, 4) || '0', 16);
                    b = parseInt(hex.substring(4, 6) || '0', 16);
                }
                return `rgba(${r}, ${g}, ${b}, ${opacity / 100})`;
            },
            
            onColorInput() {
                this.overlayColorInput = this.overlayColor;
                this.hexError = '';
                this.triggerAutoSave();
            },
            
            onHexInput() {
                // Ensure starts with #
                if (!this.overlayColorInput.startsWith('#')) {
                    this.overlayColorInput = '#' + this.overlayColorInput;
                }
                
                // Validate format
                const regex = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
                if (regex.test(this.overlayColorInput)) {
                    this.overlayColor = this.overlayColorInput;
                    this.hexError = '';
                    this.triggerAutoSave();
                } else {
                    this.hexError = 'Format warna HEX tidak valid (contoh: #B7E3F6).';
                }
            },
            
            onOpacityInput() {
                this.triggerAutoSave();
            },
            
            applyPreset(color) {
                this.overlayColor = color;
                this.overlayColorInput = color;
                this.hexError = '';
                this.triggerAutoSave();
            },
            
            copyColorCode() {
                navigator.clipboard.writeText(this.overlayColorInput).then(() => {
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                    }, 2000);
                });
            },
            
            resetToDefault() {
                // If it is in-house brand, we can guess the standard defaults:
                // living -> blue (#B7E3F6)
                // education/edu -> green (#D7E6D0)
                let targetColor = this.defaultColor;
                const name = this.selectedBrand.nama_brand.toLowerCase();
                if (name.includes('living')) {
                    targetColor = '#B7E3F6';
                } else if (name.includes('edu') || name.includes('education')) {
                    targetColor = '#D7E6D0';
                }
                
                this.overlayColor = targetColor;
                this.overlayColorInput = targetColor;
                this.overlayOpacity = this.defaultOpacity;
                this.hexError = '';
                this.triggerAutoSave();
            },
            
            triggerAutoSave() {
                if (this.hexError) return;
                
                this.saveStatus = 'saving';
                
                if (this.autoSaveTimeout) {
                    clearTimeout(this.autoSaveTimeout);
                }
                
                this.autoSaveTimeout = setTimeout(() => {
                    this.saveChangesAjax();
                }, 800); // 800ms debounce
            },
            
            saveChangesAjax() {
                const data = {
                    id_brand: this.selectedBrand.id_brand,
                    overlay_color: this.overlayColor,
                    overlay_opacity: this.overlayOpacity,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                
                fetch('{{ route('admin.brands.settings.update-ajax') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(res => {
                    if (res.success) {
                        this.saveStatus = 'saved';
                        
                        // Update our local state cache
                        const bIndex = this.brands.findIndex(b => b.id_brand == data.id_brand);
                        if (bIndex !== -1) {
                            this.brands[bIndex].overlay_color = data.overlay_color;
                            this.brands[bIndex].overlay_opacity = data.overlay_opacity;
                        }
                        
                        const ihIndex = this.inHouseBrands.findIndex(b => b.id_brand == data.id_brand);
                        if (ihIndex !== -1) {
                            this.inHouseBrands[ihIndex].overlay_color = data.overlay_color;
                            this.inHouseBrands[ihIndex].overlay_opacity = data.overlay_opacity;
                        }
                        
                        const oIndex = this.otherBrands.findIndex(b => b.id_brand == data.id_brand);
                        if (oIndex !== -1) {
                            this.otherBrands[oIndex].overlay_color = data.overlay_color;
                            this.otherBrands[oIndex].overlay_opacity = data.overlay_opacity;
                        }
                        
                        setTimeout(() => {
                            if (this.saveStatus === 'saved') {
                                this.saveStatus = 'idle';
                            }
                        }, 2500);
                    } else {
                        this.saveStatus = 'error';
                    }
                })
                .catch(err => {
                    console.error('Save failed:', err);
                    this.saveStatus = 'error';
                });
            },
            
            onSubmitForm(e) {
                if (this.hexError) {
                    e.preventDefault();
                    alert('Format HEX tidak valid. Silakan perbaiki sebelum menyimpan.');
                }
            }
        };
    }
</script>
@endpush
