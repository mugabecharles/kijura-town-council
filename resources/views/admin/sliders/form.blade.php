@extends('layouts.admin')
@section('title', $slider->exists ? 'Edit Slide' : 'New Slide')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></li>
<li class="breadcrumb-item active">{{ $slider->exists ? 'Edit' : 'New' }}</li>
@endsection
@section('content')
<form action="{{ $slider->exists ? route('admin.sliders.update',$slider) : route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($slider->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$slider->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle',$slider->subtitle) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description',$slider->description) }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text',$slider->button_text) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Button URL</label>
                        <input type="text" name="button_url" class="form-control" value="{{ old('button_url',$slider->button_url) }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Image {{ $slider->exists ? '(leave blank to keep)' : '*' }}</label>
                    @if($slider->image)
                    <img src="{{ asset('storage/'.$slider->image) }}" class="img-fluid rounded mb-2 d-block" id="imgPreview" style="max-height:120px">
                    @else
                    <img id="imgPreview" src="" class="img-fluid rounded mb-2 d-none" style="max-height:120px">
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                           accept="image/*" data-preview="imgPreview" {{ !$slider->exists ? 'required' : '' }}>
                    <div class="form-text">Recommended: 1920×700 px, max 5 MB</div>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$slider->sort_order ?? 0) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration (ms)</label>
                    <input type="number" name="duration" class="form-control" value="{{ old('duration',$slider->duration ?? 6000) }}" min="2000" step="500">
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ $slider->exists ? 'Update Slide' : 'Create Slide' }}</button>
                </div>
                @if($slider->exists)
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection
