@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Import Produk Excel
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Import banyak produk sekaligus menggunakan file Excel
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center justify-center rounded-md bg-gray-500 py-4 px-6 text-center font-medium text-white hover:bg-opacity-90">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary py-4 px-6 text-center font-medium text-white hover:bg-opacity-90">
                <i class="fas fa-plus mr-2"></i> Tambah Manual
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399]">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3068 6.91894 10.979L15.2925 1.97485C15.6257 1.6091 15.6269 1.04057 15.2984 0.826822Z" fill="white" stroke="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">Sukses</h5>
                <p class="text-base leading-relaxed text-body">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#F87171]">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0ZM5.70711 10.7071L10.7071 5.70711L9.29289 4.29289L4.29289 9.29289L5.70711 10.7071Z" fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#F87171]">Error</h5>
                <p class="text-base leading-relaxed text-body">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(session('errors') && count(session('errors')) > 0)
        <div class="flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#F87171]">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0ZM5.70711 10.7071L10.7071 5.70711L9.29289 4.29289L4.29289 9.29289L5.70711 10.7071Z" fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#F87171]">Error Validasi</h5>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach(session('errors') as $error)
                        <p class="text-base leading-relaxed text-body">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(session('image_errors') && count(session('image_errors')) > 0)
        <div class="flex w-full border-l-6 border-[#FFB800] bg-[#FFB800] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#FFB800]">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0ZM7 4H9V10H7V4ZM7 12H9V14H7V12Z" fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#FFB800]">Error Gambar</h5>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach(session('image_errors') as $error)
                        <p class="text-base leading-relaxed text-body">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(session('warnings') && count(session('warnings')) > 0)
        <div class="flex w-full border-l-6 border-[#FFB800] bg-[#FFB800] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9 mb-4">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#FFB800]">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0ZM7 4H9V10H7V4ZM7 12H9V14H7V12Z" fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-black dark:text-[#FFB800]">Peringatan</h5>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach(session('warnings') as $warning)
                        <p class="text-base leading-relaxed text-body">{{ $warning }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-gray-700 dark:bg-gray-800 sm:px-7.5 xl:pb-1">
        <!-- Tabs -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('template')" id="tab-template" class="tab-btn py-2 px-1 border-b-2 border-primary font-medium text-sm text-primary">
                    <i class="fas fa-download mr-2"></i> Template
                </button>
                <button onclick="showTab('upload-images')" id="tab-upload-images" class="tab-btn py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-images mr-2"></i> Upload Gambar
                </button>
                <button onclick="showTab('import-excel')" id="tab-import-excel" class="tab-btn py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-file-excel mr-2"></i> Import Excel
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div id="tab-content-template" class="tab-content">
            <h3 class="text-lg font-semibold text-black dark:text-white mb-4">
                <i class="fas fa-download mr-2"></i> Download Template Excel
            </h3>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Download template Excel untuk memastikan format data yang benar:
                </p>
                <a href="{{ route('admin.products.download-template') }}"
                    class="inline-flex items-center justify-center rounded-md bg-green-600 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    <i class="fas fa-file-excel mr-2"></i> Download Template Excel
                </a>
                <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                    <p>• Template berisi contoh data dan petunjuk pengisian</p>
                    <p>• Brand dan Kategori yang tersedia sudah tercantum</p>
                    <p>• Hapus baris contoh sebelum mengimport data</p>
                    <p>• Pastikan nama file gambar sesuai dengan yang akan diupload</p>
                </div>
            </div>
        </div>

        <div id="tab-content-upload-images" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-black dark:text-white mb-4">
                <i class="fas fa-images mr-2"></i> Upload Gambar Produk
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Upload Area -->
                <div>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors" id="dropZone">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 mb-2">Drag & drop gambar di sini atau klik untuk memilih</p>
                        <p class="text-sm text-gray-500">Format: JPG, PNG, GIF, WebP (Maksimal 2MB per file)</p>
                        <input type="file" id="imageInput" multiple accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('imageInput').click()" 
                            class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90">
                            <i class="fas fa-folder-open mr-2"></i> Pilih File
                        </button>
                    </div>
                    
                    <div id="uploadProgress" class="hidden mt-4">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-spinner fa-spin text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">Sedang mengupload gambar...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Images List -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-900 dark:text-white">
                            Gambar yang Diupload ({{ $uploadedImages->count() }})
                        </h4>
                        @if($uploadedImages->count() > 0)
                            <button onclick="clearAllImages()" class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-trash mr-1"></i> Hapus Semua
                            </button>
                        @endif
                    </div>
                    
                    <div id="uploadedImagesList" class="space-y-2 max-h-64 overflow-y-auto">
                        @if($uploadedImages->count() > 0)
                            @foreach($uploadedImages as $image)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg" data-filename="{{ $image['filename'] }}">
                                    <div class="flex items-center flex-1">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['filename'] }}" class="w-10 h-10 object-cover rounded mr-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $image['filename'] }}</p>
                                            <p class="text-xs text-gray-500">{{ number_format($image['size'] / 1024, 2) }} KB</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <p class="text-xs text-blue-600 font-medium">💡 Gunakan di Excel:</p>
                                                <span class="bg-blue-100 px-1 rounded text-xs font-mono cursor-pointer hover:bg-blue-200" onclick="copyFilename('{{ $image['filename'] }}')" title="Klik untuk copy">
                                                    {{ $image['filename'] }}
                                                </span>
                                                <button onclick="copyFilename('{{ $image['filename'] }}')" class="text-xs text-blue-600 hover:text-blue-800" title="Copy nama file">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="deleteImage('{{ $image['filename'] }}')" class="text-red-600 hover:text-red-800 ml-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-center py-4">Belum ada gambar yang diupload</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-content-import-excel" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-black dark:text-white mb-4">
                <i class="fas fa-file-excel mr-2"></i> Import File Excel
            </h3>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Penting:</strong> Pastikan semua gambar produk sudah diupload di tab "Upload Gambar" sebelum melakukan import Excel.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.products.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih File Excel
                    </label>
                    <div class="relative">
                        <input type="file" name="excel_file" accept=".xlsx,.xls" required
                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-green-600 file:text-white
                            hover:file:bg-opacity-90
                            cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Format: .xlsx atau .xls (Maksimal 10MB)
                    </p>
                </div>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center rounded-md bg-green-600 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    <i class="fas fa-file-excel mr-2"></i> Import Produk
                </button>
            </form>
        </div>
    </div>

    <!-- Instructions -->
    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
        <h3 class="text-lg font-semibold text-black dark:text-white mb-4">
            <i class="fas fa-info-circle mr-2"></i> Petunjuk Lengkap
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">� Langkah 1: Download Template</h4>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Download template Excel</li>
                    <li>• Lihat contoh data dan format</li>
                    <li>• Perhatikan brand & kategori tersedia</li>
                    <li>• Hapus baris contoh sebelum isi</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">� Langkah 2: Upload Gambar</h4>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Upload semua gambar produk</li>
                    <li>• Bisa multiple file sekaligus</li>
                    <li>• Format: JPG, PNG, GIF, WebP</li>
                    <li>• Copy nama file untuk Excel</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">🚀 Langkah 3: Import Excel</h4>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Upload file Excel yang sudah diisi</li>
                    <li>• System akan validasi semua data</li>
                    <li>• Gambar akan dicek keberadaannya</li>
                    <li>• Produk berhasil dibuat jika valid</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-primary', 'text-primary');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById('tab-content-' + tabName).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-primary', 'text-primary');
        }

        // Image upload functionality
        const dropZone = document.getElementById('dropZone');
        const imageInput = document.getElementById('imageInput');
        const uploadProgress = document.getElementById('uploadProgress');

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
            
            const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
            if (files.length > 0) {
                uploadImages(files);
            }
        });

        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                uploadImages(Array.from(e.target.files));
            }
        });

        function uploadImages(files) {
            uploadProgress.classList.remove('hidden');
            
            const formData = new FormData();
            files.forEach(file => {
                formData.append('images[]', file);
            });

            fetch('{{ route("admin.products.upload-images") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                uploadProgress.classList.add('hidden');
                
                if (data.success) {
                    // Refresh the page to show uploaded images
                    location.reload();
                } else {
                    alert('Upload gagal: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                uploadProgress.classList.add('hidden');
                alert('Upload gagal: ' + error.message);
            });
        }

        function deleteImage(filename) {
            if (confirm('Hapus gambar ini?')) {
                fetch('{{ route("admin.products.delete-image") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ filename: filename })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove image from list
                        const element = document.querySelector(`[data-filename="${filename}"]`);
                        if (element) {
                            element.remove();
                        }
                        // Update count
                        const countElement = document.querySelector('#uploadedImagesList').previousElementSibling.querySelector('h4');
                        const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
                        countElement.textContent = `Gambar yang Diupload (${currentCount - 1})`;
                    } else {
                        alert('Gagal menghapus gambar');
                    }
                })
                .catch(error => {
                    alert('Gagal menghapus gambar: ' + error.message);
                });
            }
        }

        function copyFilename(filename) {
            navigator.clipboard.writeText(filename).then(function() {
                // Show temporary success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                toast.innerHTML = '<i class="fas fa-check mr-2"></i> Nama file disalin: ' + filename;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                alert('Gagal menyalin nama file. Silakan copy manual: ' + filename);
            });
        }

        function clearAllImages() {
            if (confirm('Hapus semua gambar yang diupload?')) {
                fetch('{{ route("admin.products.clear-temp-images") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus gambar');
                    }
                })
                .catch(error => {
                    alert('Gagal menghapus gambar: ' + error.message);
                });
            }
        }
    </script>
@endsection
