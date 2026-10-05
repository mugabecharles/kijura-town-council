@extends('layouts.admin')
@section('title', $album->exists ? 'Edit Album' : 'New Album')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li><li class="breadcrumb-item active">{{ $album->exists ? 'Edit' : 'New' }}</li>@endsection
@section('content')
<form action="{{ $album->exists ? route('admin.gallery.update',$album) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($album->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Album Name *</label><input type="text" name="name" class="form-control" value="{{ old('name',$album->name) }}" required></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$album->description) }}</textarea></div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Category</label><input type="text" name="category" class="form-control" value="{{ old('category',$album->category) }}" placeholder="e.g. events, projects"></div>
                    <div class="col-md-6"><label class="form-label">Event Date</label><input type="date" name="event_date" class="form-control" value="{{ old('event_date',$album->event_date?->format('Y-m-d')) }}"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Cover Image</label>
                    @if($album->cover_image)<img src="{{ asset('storage/'.$album->cover_image) }}" class="img-fluid rounded mb-2 d-block" id="coverPreview" style="max-height:120px">@else<img id="coverPreview" src="" class="img-fluid rounded mb-2 d-none" style="max-height:120px">@endif
                    <input type="file" name="cover_image" class="form-control" accept="image/*" data-preview="coverPreview">
                </div>
                <div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$album->sort_order??0) }}"></div>
                <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$album->is_active??true)?'checked':'' }}><label class="form-check-label">Active</label></div>
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="show_on_homepage" value="1" {{ old('show_on_homepage',$album->show_on_homepage)?'checked':'' }}><label class="form-check-label">Show on Homepage</label></div>
                <div class="d-grid"><button type="submit" class="btn btn-primary">{{ $album->exists ? 'Update' : 'Create Album' }}</button></div>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
