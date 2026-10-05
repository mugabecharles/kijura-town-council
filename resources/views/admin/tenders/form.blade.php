@extends('layouts.admin')
@section('title', $tender->exists ? 'Edit Tender' : 'New Tender')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.tenders.index') }}">Tenders</a></li><li class="breadcrumb-item active">{{ $tender->exists ? 'Edit' : 'New' }}</li>@endsection
@section('content')
<form action="{{ $tender->exists ? route('admin.tenders.update',$tender) : route('admin.tenders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($tender->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title',$tender->title) }}" required></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Reference Number *</label><input type="text" name="reference_number" class="form-control" value="{{ old('reference_number',$tender->reference_number) }}" required></div>
                    <div class="col-md-6"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">— None —</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id',$tender->department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                </div>
                <div class="mb-3"><label class="form-label">Description *</label><textarea name="description" class="form-control" rows="5" required>{{ old('description',$tender->description) }}</textarea></div>
                <div class="mb-3"><label class="form-label">Eligibility</label><textarea name="eligibility" class="form-control" rows="3">{{ old('eligibility',$tender->eligibility) }}</textarea></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person',$tender->contact_person) }}"></div>
                    <div class="col-md-3"><label class="form-label">Phone</label><input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone',$tender->contact_phone) }}"></div>
                    <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="contact_email" class="form-control" value="{{ old('contact_email',$tender->contact_email) }}"></div>
                </div>
                <div class="mb-3"><label class="form-label">Tender Documents</label><input type="file" name="documents[]" class="form-control" multiple></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Status *</label><select name="status" class="form-select">@foreach(['open','closed','cancelled','awarded'] as $s)<option value="{{ $s }}" {{ old('status',$tender->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Published Date *</label><input type="date" name="published_date" class="form-control" value="{{ old('published_date',$tender->published_date?->format('Y-m-d')) }}" required></div>
                <div class="mb-3"><label class="form-label">Closing Date *</label><input type="date" name="closing_date" class="form-control" value="{{ old('closing_date',$tender->closing_date?->format('Y-m-d')) }}" required></div>
                <div class="mb-3"><label class="form-label">Estimated Value (UGX)</label><input type="number" name="estimated_value" class="form-control" value="{{ old('estimated_value',$tender->estimated_value) }}"></div>
                <div class="mb-3"><label class="form-label">Awarded To</label><input type="text" name="awarded_to" class="form-control" value="{{ old('awarded_to',$tender->awarded_to) }}"></div>
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$tender->is_active??true)?'checked':'' }}><label class="form-check-label">Active</label></div>
                <div class="d-grid"><button type="submit" class="btn btn-primary">{{ $tender->exists ? 'Update' : 'Create' }}</button></div>
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
