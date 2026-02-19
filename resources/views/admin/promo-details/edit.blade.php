@extends('layouts.admin')

@section('title', 'Edit Detail Informasi')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Detail Informasi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Untuk banner: {{ $promoBanner->title ?? 'Informasi Banner' }} | Detail: {{ $promoDetail->judul_detail }}
                </p>
            </div>
            <a href="{{ route('admin.promo-details.index', $promoBanner->id_promo_banner) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <form action="{{ route('admin.promo-details.update', [$promoBanner->id_promo_banner, $promoDetail->id_promo_detail]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                        <div class="text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Judul Detail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Detail <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul_detail" value="{{ old('judul_detail', $promoDetail->judul_detail) }}" required
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="4"
                                      class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('deskripsi', $promoDetail->deskripsi) }}</textarea>
                        </div>

                        <!-- Gambar Tambahan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Gambar Tambahan
                            </label>
                            @if($promoDetail->gambar_tambahan)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/images/' . $promoDetail->gambar_tambahan) }}" 
                                         alt="{{ $promoDetail->judul_detail }}" 
                                         class="h-20 w-20 rounded-lg object-cover">
                                    <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input type="file" name="gambar_tambahan" accept="image/*"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Tanggal Mulai & Selesai -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $promoDetail->tanggal_mulai) }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $promoDetail->tanggal_selesai) }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>




                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-lg text-base font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Update Detail Promo
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize flatpickr for Tanggal Mulai
    flatpickr("input[name='tanggal_mulai']", {
        dateFormat: "Y-m-d",
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        }
    });

    // Initialize flatpickr for Tanggal Selesai
    flatpickr("input[name='tanggal_selesai']", {
        dateFormat: "Y-m-d",
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        }
    });
});
</script>
@endpush
