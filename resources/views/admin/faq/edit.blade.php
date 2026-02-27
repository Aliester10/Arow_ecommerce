@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Edit FAQ
        </h2>
        <a href="{{ route('admin.faq.index') }}" 
           class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
        <div class="p-4 md:p-6 xl:p-7.5">
            <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label for="pertanyaan" class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pertanyaan <span class="text-meta-1">*</span>
                            </label>
                            <textarea name="pertanyaan" id="pertanyaan" rows="4" 
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-gray-800 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                    required>{{ old('pertanyaan', $faq->pertanyaan) }}</textarea>
                            @error('pertanyaan')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jawaban" class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Jawaban <span class="text-meta-1">*</span>
                            </label>
                            <textarea name="jawaban" id="jawaban" rows="6" 
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-gray-800 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                    required>{{ old('jawaban', $faq->jawaban) }}</textarea>
                            @error('jawaban')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="urutan" class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Urutan
                            </label>
                            <input type="number" name="urutan" id="urutan" 
                                   value="{{ old('urutan', $faq->urutan) }}" min="0"
                                   class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-gray-800 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Semakin kecil angka, semakin atas posisinya
                            </p>
                            @error('urutan')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-800">
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Aktif
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                FAQ akan ditampilkan di halaman user jika aktif
                            </p>
                        </div>

                        <div class="rounded-lg border border-stroke bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800">
                            <h6 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white">Preview</h6>
                            <div class="rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-600 dark:bg-gray-900">
                                <div class="mb-2 font-semibold text-primary dark:text-primary" id="preview-pertanyaan">
                                    {{ old('pertanyaan', $faq->pertanyaan) }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300" id="preview-jawaban">
                                    {{ old('jawaban', $faq->jawaban) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <div class="flex gap-4">
                        <a href="{{ route('admin.faq.index') }}" 
                           class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-white hover:bg-opacity-90">
                            <i class="fas fa-save mr-2"></i>
                            Update FAQ
                        </button>
                    </div>
                </div>
            </form>
            
            <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center justify-center rounded-lg border border-danger bg-danger px-6 py-2.5 text-sm font-medium text-white hover:bg-red-600">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pertanyaanField = document.getElementById('pertanyaan');
        const jawabanField = document.getElementById('jawaban');
        const previewPertanyaan = document.getElementById('preview-pertanyaan');
        const previewJawaban = document.getElementById('preview-jawaban');

        function updatePreview() {
            const pertanyaan = pertanyaanField.value.trim();
            const jawaban = jawabanField.value.trim();

            previewPertanyaan.textContent = pertanyaan || 'Pertanyaan akan muncul di sini...';
            previewJawaban.textContent = jawaban || 'Jawaban akan muncul di sini...';
        }

        pertanyaanField.addEventListener('input', updatePreview);
        jawabanField.addEventListener('input', updatePreview);
    });
    </script>
@endsection
