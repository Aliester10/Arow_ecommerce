@extends('layouts.admin')

@section('title', 'Tambah Lowongan Pekerjaan')

@section('content')
<div class="mb-6">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Tambah Lowongan Pekerjaan
    </h2>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-stroke dark:border-gray-700">
    <div class="p-6">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Left Column - Basic Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Posisi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position') }}"
                                   class="form-input @error('position') border-red-500 @enderror"
                                   placeholder="Contoh: Sales Eksekutif"
                                   required>
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lokasi Kerja <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location') }}"
                                   class="form-input @error('location') border-red-500 @enderror"
                                   placeholder="Contoh: Jakarta Timur"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe Kerja <span class="text-red-500">*</span>
                            </label>
                            <select id="employment_type" 
                                    name="employment_type" 
                                    class="form-select @error('employment_type') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Tipe Kerja</option>
                                <option value="Full Time" {{ old('employment_type') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                <option value="Part Time" {{ old('employment_type') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            @error('employment_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Tujuan CV <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="form-input @error('email') border-red-500 @enderror"
                                   placeholder="hr@perusahaan.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', 1) ? 'checked' : '' }}
                                       class="form-checkbox rounded text-orange-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Aktif (Tampilkan di halaman karir)
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Full Width Textarea Fields -->
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi Pekerjaan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6"
                                  class="form-textarea @error('description') border-red-500 @enderror w-full"
                                  placeholder="Tuliskan deskripsi pekerjaan, gunakan nomor untuk setiap poin:&#10;1. Tugas pertama&#10;2. Tugas kedua&#10;3. Tugas ketiga"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Gunakan nomor (1., 2., 3.) untuk membuat daftar tugas</p>
                    </div>

                    <div>
                        <label for="qualifications" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kualifikasi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="qualifications" 
                                  name="qualifications" 
                                  rows="6"
                                  class="form-textarea @error('qualifications') border-red-500 @enderror w-full"
                                  placeholder="Tuliskan kualifikasi, gunakan nomor untuk setiap poin:&#10;1. Pendidikan minimal&#10;2. Pengalaman kerja&#10;3. Skill yang dibutuhkan"
                                  required>{{ old('qualifications') }}</textarea>
                        @error('qualifications')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Gunakan nomor (1., 2., 3.) untuk membuat daftar kualifikasi</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.jobs.index') }}" 
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Lowongan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
