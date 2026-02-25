@extends('layouts.admin')

@section('title', 'Integrated Solutions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Integrated Solutions Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.integrated-solutions.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Section Title</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ $integratedSolution->title ?? 'Integrated Solutions for Modern Businesses' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" class="form-control" id="button_text" name="button_text" 
                                           value="{{ $integratedSolution->button_text ?? 'See Now' }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_color">Button Color</label>
                                    <input type="color" class="form-control" id="button_color" name="button_color" 
                                           value="{{ $integratedSolution->button_color ?? '#FF5F57' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="background_image">Background Image</label>
                                    <input type="file" class="form-control" id="background_image" name="background_image" 
                                           accept="image/*">
                                    @if($integratedSolution && $integratedSolution->background_image)
                                        <small class="form-text text-muted">
                                            Current: {{ $integratedSolution->background_image }}
                                            <br>
                                            <img src="{{ asset('storage/images/' . $integratedSolution->background_image) }}" 
                                                 alt="Background" style="max-width: 100px; max-height: 50px;">
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                       {{ $integratedSolution->is_active ?? 'checked' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <hr>

                        <h5>Featured Categories (Select up to 3)</h5>
                        
                        <div class="row" id="categoriesContainer">
                            @for($i = 0; $i < 3; $i++)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Category {{ $i + 1 }}</h6>
                                            
                                            <div class="form-group">
                                                <label>Select Category</label>
                                                <select class="form-control" name="categories[{{ $i }}]">
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id_kategori }}" 
                                                                {{ $selectedCategories[$i]->kategori_id ?? null == $category->id_kategori ? 'selected' : '' }}>
                                                            {{ $category->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Category Image</label>
                                                <input type="file" class="form-control" name="category_images[{{ $i }}]" 
                                                       accept="image/*">
                                                @if(isset($selectedCategories[$i]) && $selectedCategories[$i]->category_image)
                                                    <small class="form-text text-muted">
                                                        Current: {{ $selectedCategories[$i]->category_image }}
                                                        <br>
                                                        <img src="{{ asset('storage/images/' . $selectedCategories[$i]->category_image) }}" 
                                                             alt="Category" style="max-width: 100px; max-height: 50px;">
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
