@extends('layouts.admin')
@section('title', $item->exists ? 'Edit Article' : 'New Article')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
<li class="breadcrumb-item active">{{ $item->exists ? 'Edit' : 'New' }}</li>
@endsection
@section('content')
<form action="{{ $item->exists ? route('admin.news.update',$item) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($item->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$item->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt',$item->excerpt) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content *</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="12">{{ old('content',$item->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-section">
                    <div class="form-section-title">SEO</div>
                    <div class="mb-2"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control form-control-sm" value="{{ old('meta_title',$item->meta_title) }}" data-maxlength="60"></div>
                    <div class="mb-2"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control form-control-sm" rows="2" data-maxlength="160">{{ old('meta_description',$item->meta_description) }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select"><option value="draft" {{ old('status',$item->status)=='draft'?'selected':'' }}>Draft</option><option value="review" {{ old('status',$item->status)=='review'?'selected':'' }}>Review</option><option value="approved" {{ old('status',$item->status)=='approved'?'selected':'' }}>Approved</option><option value="published" {{ old('status',$item->status)=='published'?'selected':'' }}>Published</option><option value="archived" {{ old('status',$item->status)=='archived'?'selected':'' }}>Archived</option></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-select"><option value="news" {{ old('type',$item->type)=='news'?'selected':'' }}>News</option><option value="announcement" {{ old('type',$item->type)=='announcement'?'selected':'' }}>Announcement</option><option value="event" {{ old('type',$item->type)=='event'?'selected':'' }}>Event</option><option value="press_release" {{ old('type',$item->type)=='press_release'?'selected':'' }}>Press Release</option></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select"><option value="">— None —</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id',$item->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach</select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Publish Date</label>
                    <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $item->published_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at', $item->expires_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1" {{ old('is_featured',$item->is_featured)?'checked':'' }}>
                    <label class="form-check-label" for="isFeatured">Featured</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags',$item->tags) }}">
                </div>
            </div>
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    @if($item->featured_image)<img src="{{ asset('storage/'.$item->featured_image) }}" class="img-fluid rounded mb-2 d-block" id="imgPreview" style="max-height:120px">@else<img id="imgPreview" src="" class="img-fluid rounded mb-2 d-none" style="max-height:120px">@endif
                    <input type="file" name="featured_image" class="form-control" accept="image/*" data-preview="imgPreview">
                </div>
                <div class="mb-3">
                    <label class="form-label">Attachments</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ $item->exists ? 'Update' : 'Create' }}</button>
                </div>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
