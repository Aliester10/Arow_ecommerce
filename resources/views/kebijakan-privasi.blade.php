@extends('layouts.app')

@section('title', 'Kebijakan Privasi - PT Aro Baskara Esa')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-600 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Beranda</a>
        <span class="mx-2">></span>
        <span class="text-gray-900 font-medium">Kebijakan Privasi</span>
    </nav>

    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $privacyPolicy->title }}</h1>
        <h2 class="text-xl text-gray-700 mb-2">{{ $privacyPolicy->subtitle }}</h2>
        <p class="text-sm text-gray-500">Terakhir diperbarui: {{ $privacyPolicy->last_updated->format('d F Y') }}</p>
    </div>

    <!-- Introduction Paragraph -->
    <div class="bg-gray-50 rounded-lg p-6 mb-10">
        <p class="text-gray-700 leading-relaxed text-center max-w-4xl mx-auto">
            {{ $privacyPolicy->introduction }}
        </p>
    </div>

    <!-- Sections Grid -->
    <div class="grid md:grid-cols-2 gap-8">
        @foreach($privacyPolicy->sections as $index => $section)
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    @switch($index % 6)
                        @case(0)
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            @break
                        @case(1)
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            @break
                        @case(2)
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            @break
                        @case(3)
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            @break
                        @case(4)
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            @break
                        @case(5)
                            <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            @break
                    @endswitch
                    {{ $section['title'] }}
                </h3>
                <ul class="space-y-2 text-gray-600 mb-4">
                    @foreach($section['items'] as $item)
                        <li class="flex items-start">
                            @switch($index % 6)
                                @case(0)
                                    <span class="text-blue-600 mr-2 mt-1">•</span>
                                    @break
                                @case(1)
                                    <span class="text-green-600 mr-2 mt-1">•</span>
                                    @break
                                @case(2)
                                    <span class="text-purple-600 mr-2 mt-1">•</span>
                                    @break
                                @case(3)
                                    <span class="text-orange-600 mr-2 mt-1">•</span>
                                    @break
                                @case(4)
                                    <span class="text-indigo-600 mr-2 mt-1">•</span>
                                    @break
                                @case(5)
                                    <span class="text-pink-600 mr-2 mt-1">•</span>
                                    @break
                            @endswitch
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
                @if(!empty($section['description']))
                    <p class="text-sm text-gray-500 italic mt-3 pt-3 border-t border-gray-100">
                        {{ $section['description'] }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
