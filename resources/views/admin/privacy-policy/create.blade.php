@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Tambah Kebijakan Privasi
        </h2>
    </div>

    <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
        <form action="{{ route('admin.privacy-policy.store') }}" method="POST" class="p-4 md:p-6 xl:p-7.5">
            @csrf
            
            <!-- Basic Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                               placeholder="Kebijakan Privasi"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subjudul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle') }}"
                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                               placeholder="PT Aro Baskara Esa"
                               required>
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="last_updated" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Terakhir Diperbarui <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="last_updated" 
                           name="last_updated" 
                           value="{{ old('last_updated', now()->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                           required>
                    @error('last_updated')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="introduction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Paragraf Pembuka <span class="text-red-500">*</span>
                    </label>
                    <textarea id="introduction" 
                              name="introduction" 
                              rows="4"
                              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                              placeholder="Di PT Aro Baskara Esa, kami berkomitmen untuk melindungi data pribadi pengguna..."
                              required>{{ old('introduction') }}</textarea>
                    @error('introduction')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sections -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Bagian Kebijakan</h3>
                <div id="sections-container">
                    <div class="section-item mb-4 p-4 border border-gray-200 rounded-lg dark:border-gray-600">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-medium text-gray-900 dark:text-white">Bagian 1</h4>
                            <button type="button" class="remove-section text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <input type="text" 
                                   name="sections[0][title]" 
                                   placeholder="Judul Bagian"
                                   class="section-title w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                   value="{{ old('sections.0.title') }}">
                            
                            <div class="section-items">
                                <div class="item-input mb-2 flex gap-2">
                                    <input type="text" 
                                           name="sections[0][items][]" 
                                           placeholder="Item 1"
                                           class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                           value="{{ old('sections.0.items.0') }}">
                                    <button type="button" class="remove-item text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="button" class="add-item text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Item
                            </button>
                            
                            <textarea name="sections[0][description]" 
                                      rows="2"
                                      placeholder="Deskripsi tambahan (opsional)"
                                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ old('sections.0.description') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-section" class="mt-4 inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-sm font-medium text-white transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Bagian
                </button>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active') ? 'checked' : '' }}
                           class="rounded border-gray-300 bg-white text-primary focus:border-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-800">
                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Aktif</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.privacy-policy.index') }}" 
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        let sectionIndex = 1;

        document.getElementById('add-section').addEventListener('click', function() {
            const container = document.getElementById('sections-container');
            const sectionHtml = `
                <div class="section-item mb-4 p-4 border border-gray-200 rounded-lg dark:border-gray-600">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-900 dark:text-white">Bagian ${sectionIndex + 1}</h4>
                        <button type="button" class="remove-section text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <input type="text" 
                               name="sections[${sectionIndex}][title]" 
                               placeholder="Judul Bagian"
                               class="section-title w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        
                        <div class="section-items">
                            <div class="item-input mb-2 flex gap-2">
                                <input type="text" 
                                       name="sections[${sectionIndex}][items][]" 
                                       placeholder="Item 1"
                                       class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                <button type="button" class="remove-item text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" class="add-item text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Item
                        </button>
                        
                        <textarea name="sections[${sectionIndex}][description]" 
                                  rows="2"
                                  placeholder="Deskripsi tambahan (opsional)"
                                  class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"></textarea>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', sectionHtml);
            sectionIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-section')) {
                e.target.closest('.section-item').remove();
            }
            
            if (e.target.closest('.add-item')) {
                const sectionItems = e.target.closest('.section-item').querySelector('.section-items');
                const sectionIndex = Array.from(document.querySelectorAll('.section-item')).indexOf(e.target.closest('.section-item'));
                const itemIndex = sectionItems.querySelectorAll('.item-input').length;
                const itemHtml = `
                    <div class="item-input mb-2 flex gap-2">
                        <input type="text" 
                               name="sections[${sectionIndex}][items][]"
                               placeholder="Item baru"
                               class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-primary focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <button type="button" class="remove-item text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                sectionItems.insertAdjacentHTML('beforeend', itemHtml);
                console.log(`Added item to section ${sectionIndex} with name sections[${sectionIndex}][items][]`);
            }
            
            if (e.target.closest('.remove-item')) {
                e.target.closest('.item-input').remove();
            }
        });

        // Debug form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitted');
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
        });
    </script>
@endsection
