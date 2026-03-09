@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Blog Posts
        </h2>
        <a href="{{ route('admin.blog.create') }}" 
           class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
            <i class="fas fa-plus mr-2"></i> Add New Post
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-green-700">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="px-4 py-6 md:px-6 xl:px-7.5">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                All Blog Posts
            </h4>
        </div>

        <div class="grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-3 flex items-center">
                <p class="font-medium">Title</p>
            </div>
            <div class="col-span-2 hidden items-center sm:flex">
                <p class="font-medium">Author</p>
            </div>
            <div class="col-span-1 flex items-center">
                <p class="font-medium">Status</p>
            </div>
            <div class="col-span-1 flex items-center">
                <p class="font-medium">Views</p>
            </div>
            <div class="col-span-1 flex items-center justify-end">
                <p class="font-medium">Actions</p>
            </div>
        </div>

        @forelse($posts as $post)
            <div class="grid grid-cols-6 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-3 flex items-center">
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-medium text-black dark:text-white">
                            {{ Str::limit($post->title, 50) }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $post->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
                <div class="col-span-2 hidden items-center sm:flex">
                    <p class="text-sm text-black dark:text-white">
                        {{ $post->author?->name ?? 'Unknown' }}
                    </p>
                </div>
                <div class="col-span-1 flex items-center">
                    @if($post->is_published)
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                            Published
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                            Draft
                        </span>
                    @endif
                </div>
                <div class="col-span-1 flex items-center">
                    <p class="text-sm text-black dark:text-white">
                        {{ $post->views }}
                    </p>
                </div>
                <div class="col-span-1 flex items-center justify-end gap-2">
                    <form action="{{ route('admin.blog.toggle-status', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="text-gray-500 hover:text-primary transition-colors"
                                title="{{ $post->is_published ? 'Unpublish' : 'Publish' }}">
                            <i class="fas fa-{{ $post->is_published ? 'eye-slash' : 'eye' }}"></i>
                        </button>
                    </form>
                    <a href="{{ route('admin.blog.edit', $post) }}" 
                       class="text-gray-500 hover:text-primary transition-colors"
                       title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-gray-500 hover:text-red-500 transition-colors"
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="border-t border-stroke px-4 py-8 text-center dark:border-strokedark">
                <p class="text-gray-500">No blog posts found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
