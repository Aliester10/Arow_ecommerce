@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Blog Header -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $post->title }}</h1>
                <div class="flex items-center justify-center text-sm opacity-90 space-x-4">
                    <span><i class="far fa-calendar mr-1"></i> {{ $post->published_at_formatted }}</span>
                    <span>•</span>
                    <span><i class="far fa-user mr-1"></i> {{ $post->author?->name ?? 'Admin' }}</span>
                    <span>•</span>
                    <span><i class="far fa-eye mr-1"></i> {{ $post->views }} views</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Featured Image -->
                @if($post->image)
                    <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ Storage::url($post->image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-auto">
                    </div>
                @endif

                <!-- Blog Content -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Share Section -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Share this post</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                           target="_blank"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f mr-2"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $post->title }}" 
                           target="_blank"
                           class="bg-sky-500 text-white px-4 py-2 rounded hover:bg-sky-600 transition-colors">
                            <i class="fab fa-twitter mr-2"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ $post->title }} {{ url()->current() }}" 
                           target="_blank"
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Related Posts</h2>
                    <p class="text-gray-600">Discover more articles you might find interesting</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($relatedPost->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::url($relatedPost->image) }}" 
                                         alt="{{ $relatedPost->title }}" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span><i class="far fa-calendar mr-1"></i> {{ $relatedPost->published_at_formatted }}</span>
                                </div>
                                
                                <h3 class="text-lg font-semibold mb-3 text-gray-800 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                        {{ Str::limit($relatedPost->title, 60) }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    {{ $relatedPost->excerpt }}
                                </p>
                                
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                    Read More 
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Back to Blog -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Blog
                </a>
            </div>
        </div>
    </section>
@endsection
