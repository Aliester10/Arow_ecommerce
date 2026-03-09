@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Blog</h1>
                <p class="text-xl opacity-90">Stay updated with the latest news, tips, and insights</p>
            </div>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($post->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span><i class="far fa-calendar mr-1"></i> {{ $post->published_at_formatted }}</span>
                                    <span class="mx-2">•</span>
                                    <span><i class="far fa-eye mr-1"></i> {{ $post->views }} views</span>
                                </div>
                                
                                <h3 class="text-xl font-semibold mb-3 text-gray-800 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $post->excerpt }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">
                                        <i class="far fa-user mr-1"></i> 
                                        {{ $post->author?->name ?? 'Admin' }}
                                    </span>
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                        Read More 
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-blog text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">No blog posts yet</h3>
                    <p class="text-gray-500">Check back later for exciting content!</p>
                </div>
            @endif
        </div>
    </section>
@endsection
