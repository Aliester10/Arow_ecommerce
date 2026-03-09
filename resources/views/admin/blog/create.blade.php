@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Create Blog Post
        </h2>
        <a href="{{ route('admin.blog.index') }}" 
           class="inline-flex items-center justify-center rounded-md bg-gray-500 px-4 py-2 text-center font-medium text-white hover:bg-opacity-90">
            <i class="fas fa-arrow-left mr-2"></i> Back to Posts
        </a>
    </div>

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6.5">
                @if($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Title <span class="text-meta-1">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                           placeholder="Enter blog post title"
                           required>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Slug
                    </label>
                    <input type="text" 
                           name="slug" 
                           value="{{ old('slug') }}"
                           class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                           placeholder="Leave empty to auto-generate from title">
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Excerpt
                    </label>
                    <textarea name="excerpt" 
                              rows="3"
                              class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                              placeholder="Brief description of the blog post">{{ old('excerpt') }}</textarea>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Content <span class="text-meta-1">*</span>
                    </label>
                    <textarea name="content" 
                              rows="10"
                              class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                              placeholder="Write your blog content here..."
                              required>{{ old('content') }}</textarea>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Featured Image
                    </label>
                    <input type="file" 
                           name="image" 
                           accept="image/*"
                           class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    <p class="mt-1 text-xs text-gray-500">Allowed formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4.5 mb-4.5">
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white">
                            Meta Title
                        </label>
                        <input type="text" 
                               name="meta_title" 
                               value="{{ old('meta_title') }}"
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                               placeholder="SEO meta title">
                    </div>

                    <div>
                        <label class="mb-2.5 block text-black dark:text-white">
                            Published At
                        </label>
                        <input type="datetime-local" 
                               name="published_at" 
                               value="{{ old('published_at') }}"
                               class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Meta Description
                    </label>
                    <textarea name="meta_description" 
                              rows="3"
                              class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                              placeholder="SEO meta description">{{ old('meta_description') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="is_published" 
                               value="1"
                               class="sr-only peer"
                               {{ old('is_published') ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Publish immediately
                        </span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.blog.index') }}" 
                       class="inline-flex items-center justify-center rounded-md bg-gray-500 px-6 py-2 text-center font-medium text-white hover:bg-opacity-90">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center rounded-md bg-primary px-6 py-2 text-center font-medium text-white hover:bg-opacity-90">
                        <i class="fas fa-save mr-2"></i> Create Post
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
