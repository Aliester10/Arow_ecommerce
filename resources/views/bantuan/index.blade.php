@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/images/bgbantuan.png') }}');">
    <div class="absolute inset-0 bg-white/10"></div>
    <div class="relative container mx-auto px-4 py-16 md:py-24">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Left Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-6">
                    Ada yang Bisa Kami Bantu?
                </h1>
                <p class="text-xl md:text-2xl text-black mb-8">
                    Temukan solusi cepat untuk kendala Anda
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-start lg:justify-start">
                    <a href="#hubungi-kami" 
                       class="px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 text-center">
                        <i class="fas fa-headset mr-2"></i>
                        Hubungi CS
                    </a>
                    <a href="https://wa.me/6282288886009" target="_blank"
                       class="px-8 py-4 bg-white hover:bg-gray-50 text-green-600 font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 text-center border border-green-500">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    </section>

<!-- Hubungi Kami Section -->
<section id="hubungi-kami" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-left mb-12 flex items-center">
            <div class="h-10 w-1 bg-orange-600 mr-4"></div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Hubungi Kami</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card Telepon -->
            <div class="bg-white rounded-[15px] shadow-lg overflow-hidden">
                <div class="bg-[#536AFF] p-4 flex items-center justify-center space-x-3 rounded-t-[15px]">
                    <div class="bg-white rounded-full p-2">
                        <i class="fas fa-phone-alt text-[#536AFF] text-xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold">Telepon</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-800 text-lg font-semibold mb-2">(021) 38835187</p>
                    <p class="text-gray-600 text-sm mb-6">Senin – Jumat, 08.00 – 17.00 WIB</p>
                    <a href="tel:02138835187" class="block w-full py-3 bg-[#536AFF] text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Telepon Sekarang
                    </a>
                </div>
            </div>
            
            <!-- Card WhatsApp -->
            <div class="bg-white rounded-[15px] shadow-lg overflow-hidden">
                <div class="bg-[#30CD00] p-4 flex items-center justify-center space-x-3 rounded-t-[15px]">
                    <div class="bg-white rounded-full p-2">
                        <i class="fab fa-whatsapp text-[#51C85D] text-xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold">WhatsApp</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-800 text-lg font-semibold mb-2">+62 822-8888-6009</p>
                    <p class="text-gray-600 text-sm mb-6">Senin – Minggu, 08.00 – 17.00 WIB</p>
                    <a href="https://wa.me/6282288886009" target="_blank" class="block w-full py-3 bg-[#30CD00] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-300">
                        Chat Sekarang
                    </a>
                </div>
            </div>
            
            <!-- Card Email -->
            <div class="bg-white rounded-[15px] shadow-lg overflow-hidden">
                <div class="bg-[#F7931E] p-4 flex items-center justify-center space-x-3 rounded-t-[15px]">
                    <div class="bg-white rounded-full p-2">
                        <i class="fas fa-envelope text-[#F7931E] text-xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold">Email</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-800 text-lg font-semibold mb-2">sales@ayabelanja.co.id</p>
                    <p class="text-gray-600 text-sm mb-6">24 Jam</p>
                    <a href="mailto:sales@ayabelanja.co.id" class="block w-full py-3 bg-[#F7931E] text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors duration-300">
                        Chat Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Panduan dan FAQ Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-start mb-8">
            <div class="h-20 w-1 bg-gray-800 mr-4"></div>
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Panduan dan FAQ</h2>
                <p class="text-lg text-gray-500 pl-8">Akses Cepat ke Pertanyaan Populer</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left: Accordion FAQ -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Pertanyaan Umum</h3>
                <div class="space-y-4">
                    @forelse($faqs as $index => $faq)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button onclick="toggleFAQ({{ $index + 1 }})" class="w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 text-left flex justify-between items-center transition-colors">
                                <span class="font-semibold text-gray-800">{{ $faq->pertanyaan }}</span>
                                <i id="faq-icon-{{ $index + 1 }}" class="fas fa-chevron-down text-gray-600 transition-transform"></i>
                            </button>
                            <div id="faq-content-{{ $index + 1 }}" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                                <div class="text-gray-600">{!! $faq->jawaban !!}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-question-circle fa-3x text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada pertanyaan yang tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Right: Form Laporkan Kendala -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Laporkan Kendala</h3>
                <form id="reportForm" class="bg-gray-50 rounded-2xl p-8 shadow-lg">
                    <div class="mb-6">
                        <label for="orderNumber" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-shopping-cart mr-2 text-orange-500"></i>
                            No. Pesanan
                        </label>
                        <input type="text" id="orderNumber" name="orderNumber" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Masukkan nomor pesanan Anda">
                    </div>
                    
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2 text-orange-500"></i>
                            Email
                        </label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="email@example.com">
                    </div>
                    
                    <div class="mb-6">
                        <label for="issue" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-2 text-orange-500"></i>
                            Kendala yang Dihadapi
                        </label>
                        <textarea id="issue" name="issue" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                  placeholder="Jelaskan kendala yang Anda alami secara detail..."></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label for="evidence" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-paperclip mr-2 text-orange-500"></i>
                            Upload Bukti (jpg/png/pdf)
                        </label>
                        <div class="relative">
                            <input type="file" id="evidence" name="evidence" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            <p class="text-sm text-gray-500 mt-2">Maksimal ukuran file: 5MB</p>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 transform scale-95 transition-transform">
        <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-3xl text-green-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Laporan Terkirim!</h3>
            <p class="text-gray-600 mb-6">Terima kasih telah melaporkan kendala Anda. Tim kami akan segera menghubungi Anda.</p>
            <button onclick="closeModal()" 
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<script>
// FAQ Accordion functionality
function toggleFAQ(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Form submission
document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
    
    fetch('/complaints', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show success modal
            document.getElementById('successModal').classList.remove('hidden');
            document.getElementById('successModal').querySelector('.bg-white').style.transform = 'scale(1)';
            
            // Reset form
            this.reset();
        } else {
            // Show error message
            alert(data.message || 'Terjadi kesalahan saat mengirim laporan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim laporan. Silakan coba lagi. Error: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Close modal
function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// File upload validation
document.getElementById('evidence').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        
        if (file.size > maxSize) {
            alert('Ukuran file maksimal 5MB');
            this.value = '';
            return;
        }
        
        if (!allowedTypes.includes(file.type)) {
            alert('Hanya file JPG, PNG, dan PDF yang diperbolehkan');
            this.value = '';
            return;
        }
    }
});
</script>

<style>
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s ease;
}

/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #F7931E;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #e67e00;
}
</style>
@endsection
