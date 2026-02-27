@extends('layouts.app')

@section('title', 'Kebijakan Privasi - PT Aro Baskara Esa')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-600 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Beranda</a>
        <span class="mx-2">></span>
        <span class="text-gray-900 font-medium">Kebijakan Privasi</span>
    </nav>

    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="mb-8">
            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Kebijakan Privasi</h1>
        <p class="text-lg text-gray-600 mb-8">
            Kebijakan Privasi saat ini tidak tersedia. <br>
            Silakan hubungi administrator untuk informasi lebih lanjut.
        </p>
        
        <div class="bg-gray-50 rounded-lg p-6 max-w-md mx-auto">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Hubungi Kami</h3>
            <p class="text-gray-600 mb-4">
                Untuk informasi mengenai kebijakan privasi, Anda dapat menghubungi kami melalui:
            </p>
            <div class="space-y-2 text-left">
                <p class="text-sm text-gray-600">
                    <strong>Email:</strong> info@arobaskaraesa.com
                </p>
                <p class="text-sm text-gray-600">
                    <strong>Telepon:</strong> +62 21 1234 5678
                </p>
            </div>
        </div>
        
        <div class="mt-8">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-medium text-white hover:bg-opacity-90 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
