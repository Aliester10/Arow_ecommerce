@extends('layouts.admin')

@section('title', 'Detail Laporan Kendala #' . $complaint->id)

@section('content')
<div class="space-y-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">
            <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
            Detail Laporan Kendala #{{ $complaint->id }}
        </h4>
        <div>
            <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="bg-blue-500 text-white px-6 py-4 rounded-t-xl">
            <h5 class="text-lg font-semibold">Informasi Laporan</h5>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">ID Laporan:</span>
                        <span class="text-sm text-gray-900 dark:text-white">#{{ $complaint->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">No. Pesanan:</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $complaint->order_number ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Email Pelapor:</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $complaint->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($complaint->status == 'pending') bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400
                            @elseif($complaint->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                            @else bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 @endif">
                            {{ $complaint->status_label }}
                        </span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Kirim:</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $complaint->created_at->format('d F Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Terakhir Update:</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $complaint->updated_at->format('d F Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">File Bukti:</span>
                        <div>
                            @if($complaint->evidence_file_path)
                                <a href="{{ route('admin.complaints.download', $complaint->id) }}" 
                                   class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    <i class="fas fa-download mr-1"></i>Download File
                                </a>
                            @else
                                <span class="text-gray-400 dark:text-gray-500 text-sm">Tidak ada file bukti</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="bg-blue-500 text-white px-6 py-4 rounded-t-xl">
                    <h5 class="text-lg font-semibold">Deskripsi Kendala</h5>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $complaint->issue_description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="bg-orange-500 text-white px-6 py-4 rounded-t-xl">
                    <h5 class="text-lg font-semibold">Update Status</h5>
                </div>
                <div class="p-6">
                    <form action="/admin/complaints/{{ $complaint->id }}/status" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status" id="statusSelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>Diproses</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Admin</label>
                            <textarea name="admin_notes" id="adminNotes" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Tambahkan catatan tentang penanganan laporan ini...">{{ $complaint->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            <i class="fas fa-save mr-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($complaint->admin_notes)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="bg-gray-600 text-white px-6 py-4 rounded-t-xl">
                <h5 class="text-lg font-semibold">Catatan Admin</h5>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $complaint->admin_notes }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Form submission handled by regular HTML form submission -->
@endpush
