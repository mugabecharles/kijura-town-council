@extends('layouts.admin')
@section('title', $document->exists ? 'Edit Document' : 'Upload Document')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.documents.index') }}">Documents</a></li><li class="breadcrumb-item active">{{ $document->exists ? 'Edit' : 'Upload' }}</li>@endsection
@section('content')
<form action="{{ $document->exists ? route('admin.documents.update',$document) : route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($document->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title',$document->title) }}" required></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">— None —</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id',$document->category_id)==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
                    <div class="col-md-6"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">— None —</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id',$document->department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                </div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$document->description) }}</textarea></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Year</label><input type="text" name="year" class="form-control" value="{{ old('year',$document->year ?? date('Y')) }}" placeholder="e.g. 2026"></div>
                    <div class="col-md-6"><label class="form-label">Published Date *</label><input type="date" name="published_date" class="form-control" value="{{ old('published_date',$document->published_date?->format('Y-m-d') ?? date('Y-m-d')) }}" required></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">File {{ $document->exists ? '(leave blank to keep current)' : '*' }}</label>
                    @if($document->exists)<div class="alert alert-info py-2 small mb-2"><i class="bi bi-file-earmark me-1"></i>Current: {{ $document->file_name }} ({{ $document->file_size_formatted }})</div>@endif
                    <input type="file" name="file" class="form-control" {{ !$document->exists ? 'required' : '' }} accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.png">
                    <div class="form-text">Allowed: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG. Max 20 MB.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_public" value="1" {{ old('is_public',$document->is_public??true)?'checked':'' }}><label class="form-check-label">Publicly downloadable</label></div>
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$document->is_active??true)?'checked':'' }}><label class="form-check-label">Active</label></div>
                <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control form-control-sm" value="{{ old('meta_title',$document->meta_title) }}"></div>
                <div class="d-grid"><button type="submit" class="btn btn-primary">{{ $document->exists ? 'Update' : 'Upload' }}</button></div>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
