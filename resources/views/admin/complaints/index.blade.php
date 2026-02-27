@extends('layouts.admin')

@section('title', 'Kelola Laporan Kendala')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">
            <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
            Kelola Laporan Kendala
        </h4>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.complaints.index', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-lg border transition-colors {{ $status == 'all' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
                Semua
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg border transition-colors {{ $status == 'pending' ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'in_progress']) }}" 
               class="px-4 py-2 rounded-lg border transition-colors {{ $status == 'in_progress' ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
                Diproses
            </a>
            <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" 
               class="px-4 py-2 rounded-lg border transition-colors {{ $status == 'resolved' ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600' }}">
                Selesai
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        @if($complaints->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Pesanan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kendala</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">File Bukti</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($complaints as $complaint)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">#{{ $complaint->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $complaint->order_number ?: '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $complaint->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="max-w-xs truncate" title="{{ $complaint->issue_description }}">
                                        {{ Str::limit($complaint->issue_description, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($complaint->evidence_file_path)
                                        <a href="{{ route('admin.complaints.download', $complaint->id) }}" 
                                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                            <i class="fas fa-download mr-1"></i> Download
                                        </a>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($complaint->status == 'pending') bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400
                                        @elseif($complaint->status == 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                        @else bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 @endif">
                                        {{ $complaint->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $complaint->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                                onclick="openStatusModal({{ $complaint->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                {{ $complaints->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h5 class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">Belum ada laporan kendala</h5>
                <p class="text-gray-500 dark:text-gray-500">Belum ada laporan kendala yang masuk untuk status ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status modal data
    window.complaintData = @json($complaints->items());
    
    // Open status modal function
    window.openStatusModal = function(complaintId) {
        const complaint = window.complaintData.find(c => c.id === complaintId);
        if (!complaint) return;
        
        // Create modal if it doesn't exist
        let modal = document.getElementById('statusModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'statusModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Status Laporan #<span id="modalComplaintId"></span></h3>
                        <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form id="modalStatusForm">
                        <input type="hidden" name="complaint_id" id="modalComplaintIdInput">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status" id="modalStatusSelect" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="pending">Menunggu</option>
                                <option value="in_progress">Diproses</option>
                                <option value="resolved">Selesai</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Admin</label>
                            <textarea name="admin_notes" id="modalAdminNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Tambahkan catatan..."></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Populate modal with complaint data
        document.getElementById('modalComplaintId').textContent = complaint.id;
        document.getElementById('modalComplaintIdInput').value = complaint.id;
        document.getElementById('modalStatusSelect').value = complaint.status;
        document.getElementById('modalAdminNotes').value = complaint.admin_notes || '';
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Handle form submission
        document.getElementById('modalStatusForm').onsubmit = function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            
            fetch(`/admin/complaints/${complaint.id}/status`, {
                method: 'PUT',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeStatusModal();
                    location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat memperbarui status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status. Silakan coba lagi.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        };
    };
    
    // Close modal function
    window.closeStatusModal = function() {
        const modal = document.getElementById('statusModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };
});
</script>
@endpush
