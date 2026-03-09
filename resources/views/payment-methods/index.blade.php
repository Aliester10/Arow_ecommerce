@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm text-gray-600">
        <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">Beranda</a>
        <span class="mx-2">></span>
        <span class="text-gray-900 font-medium">Metode Pembayaran</span>
    </nav>

    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Metode Pembayaran</h1>
        <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Kami menyediakan berbagai metode pembayaran untuk memudahkan transaksi di website. Pilih metode pembayaran yang sesuai dengan kebutuhan.
        </p>
    </div>

    <!-- Payment Methods Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
        <!-- Transfer Bank Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 md:p-8 text-white shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex flex-col items-center text-center">
                <!-- Bank Icon -->
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 md:mb-6 backdrop-blur-sm">
                    <i class="fas fa-building-columns text-2xl md:text-3xl"></i>
                </div>
                
                <h3 class="text-xl md:text-2xl font-bold mb-2">Transfer Bank</h3>
                <p class="text-blue-100 text-sm md:text-base mb-3 md:mb-4">(Pembayaran transfer manual)</p>
                <p class="text-blue-50 text-sm md:text-base mb-6 leading-relaxed">Pembayaran manual ke rekening resmi perusahaan</p>
                
                <!-- Bank Logos from Footer Payment Data -->
                <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-6 md:mb-8">
                    @if(isset($paymentLinks) && $paymentLinks->isNotEmpty())
                        @foreach($paymentLinks->take(4) as $payment)
                            @if($payment->image_path)
                                <div class="bg-white rounded-lg p-2 md:p-3 flex items-center justify-center shadow-sm">
                                    <img src="{{ asset('storage/footer_images/' . $payment->image_path) }}" 
                                         alt="{{ $payment->label }}" 
                                         class="h-6 md:h-8 w-auto object-contain">
                                </div>
                            @endif
                        @endforeach
                    @else
                        <!-- Default bank logos if no data available -->
                        <div class="bg-white rounded-lg p-2 md:p-3 flex items-center justify-center shadow-sm">
                            <span class="text-blue-600 font-bold text-xs md:text-sm">BRI</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 md:p-3 flex items-center justify-center shadow-sm">
                            <span class="text-blue-600 font-bold text-xs md:text-sm">Mandiri</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 md:p-3 flex items-center justify-center shadow-sm">
                            <span class="text-blue-600 font-bold text-xs md:text-sm">BNI</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 md:p-3 flex items-center justify-center shadow-sm">
                            <span class="text-blue-600 font-bold text-xs md:text-sm">BCA</span>
                        </div>
                    @endif
                </div>
                
                </div>
        </div>

        <!-- QRIS Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 md:p-8 text-white shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex flex-col items-center text-center">
                <!-- QRIS Icon -->
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 md:mb-6 backdrop-blur-sm">
                    <i class="fas fa-qrcode text-2xl md:text-3xl"></i>
                </div>
                
                <h3 class="text-xl md:text-2xl font-bold mb-4">QRIS</h3>
                <p class="text-green-50 text-sm md:text-base mb-6 leading-relaxed">Pembayaran melalui QRIS</p>
                
                <!-- QR Code Placeholder -->
                <div class="bg-white p-3 md:p-4 rounded-lg mb-6 md:mb-8 shadow-lg">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-qrcode text-4xl md:text-6xl text-gray-400"></i>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Quotation Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-6 md:p-8 text-white shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex flex-col items-center text-center">
                <!-- Quotation Icon -->
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 md:mb-6 backdrop-blur-sm">
                    <i class="fas fa-file-invoice text-2xl md:text-3xl"></i>
                </div>
                
                <h3 class="text-xl md:text-2xl font-bold mb-4">Quotation</h3>
                <p class="text-yellow-50 text-sm md:text-base mb-6 leading-relaxed">Penawaran resmi untuk kebutuhan bisnis dan retail</p>
                
                <!-- Quotation Illustration -->
                <div class="bg-white/10 p-4 md:p-6 rounded-lg mb-6 md:mb-8 backdrop-blur-sm">
                    <div class="w-24 h-24 md:w-32 md:h-32 flex items-center justify-center">
                        <i class="fas fa-file-contract text-4xl md:text-6xl text-white/80"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
