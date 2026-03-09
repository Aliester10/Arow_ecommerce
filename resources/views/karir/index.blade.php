@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Karir</h1>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Bergabunglah dengan tim kami dan kembangkan karir Anda bersama platform e-commerce terkemuka untuk pengadaan bisnis.
                </p>
            </div>
            <div class="flex-shrink-0">
                <div class="w-64 h-64 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-white text-6xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Jobs Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Lowongan Tersedia</h2>
        
        @if($jobs->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($jobs as $job)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $job->position }}</h3>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Deskripsi Pekerjaan</h4>
                            <div class="text-gray-600 text-sm whitespace-pre-line">{{ $job->description }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Kualifikasi</h4>
                            <div class="text-gray-600 text-sm whitespace-pre-line">{{ $job->qualifications }}</div>
                        </div>
                        
                        <div class="flex items-center gap-4 mb-6 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-orange-500"></i>
                                <span>{{ $job->location }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-clock text-orange-500"></i>
                                <span>{{ $job->employment_type }}</span>
                            </div>
                        </div>
                        
                        <button onclick="showApplyModal('{{ $job->position }}', '{{ $job->email }}')" 
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                            Lamar Sekarang
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg">Belum ada lowongan tersedia saat ini.</p>
                <p class="text-gray-500 text-sm mt-2">Silakan kembali lagi di lain waktu.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($jobs->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-lg shadow-sm p-4">
            <div class="text-sm text-gray-600">
                {{ $jobs->firstItem() }}–{{ $jobs->lastItem() }} dari {{ $jobs->total() }} Lowongan
            </div>
            <div class="flex gap-2">
                {{ $jobs->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Apply Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6 relative">
        <button onclick="closeApplyModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope text-orange-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Lamar Posisi: <span id="modalPosition"></span></h3>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-gray-700 text-center">
                Silakan kirim CV dan portofolio Anda ke email:
            </p>
            <p class="text-orange-600 font-semibold text-center mt-2">
                <i class="fas fa-envelope mr-2"></i>
                <span id="modalEmail"></span>
            </p>
        </div>
        
        <div class="flex gap-3">
            <button onclick="closeApplyModal()" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">
                Tutup
            </button>
            <button onclick="copyEmail()" 
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-copy mr-2"></i>
                Salin Email
            </button>
        </div>
    </div>
</div>

<script>
function showApplyModal(position, email) {
    document.getElementById('modalPosition').textContent = position;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('applyModal').classList.remove('hidden');
}

function closeApplyModal() {
    document.getElementById('applyModal').classList.add('hidden');
}

function copyEmail() {
    const email = document.getElementById('modalEmail').textContent;
    navigator.clipboard.writeText(email).then(function() {
        // Show success feedback
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i>Tersalin!';
        button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
        button.classList.add('bg-green-500', 'hover:bg-green-600');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-green-500', 'hover:bg-green-600');
            button.classList.add('bg-orange-500', 'hover:bg-orange-600');
        }, 2000);
    });
}

// Close modal when clicking outside
document.getElementById('applyModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeApplyModal();
    }
});
</script>
@endsection
