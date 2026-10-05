@extends('layouts.admin')
@section('title', $vacancy->exists ? 'Edit Vacancy' : 'New Vacancy')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.vacancies.index') }}">Vacancies</a></li><li class="breadcrumb-item active">{{ $vacancy->exists ? 'Edit' : 'New' }}</li>@endsection
@section('content')
<form action="{{ $vacancy->exists ? route('admin.vacancies.update',$vacancy) : route('admin.vacancies.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($vacancy->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title',$vacancy->title) }}" required></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4"><label class="form-label">Type *</label><select name="type" class="form-select">@foreach(['vacancy','internship','training','scholarship'] as $t)<option value="{{ $t }}" {{ old('type',$vacancy->type)==$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">— None —</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id',$vacancy->department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Reference No.</label><input type="text" name="reference_number" class="form-control" value="{{ old('reference_number',$vacancy->reference_number) }}"></div>
                </div>
                <div class="mb-3"><label class="form-label">Description *</label><textarea name="description" class="form-control" rows="5" required>{{ old('description',$vacancy->description) }}</textarea></div>
                <div class="mb-3"><label class="form-label">Requirements</label><textarea name="requirements" class="form-control" rows="4">{{ old('requirements',$vacancy->requirements) }}</textarea></div>
                <div class="mb-3"><label class="form-label">Responsibilities</label><textarea name="responsibilities" class="form-control" rows="4">{{ old('responsibilities',$vacancy->responsibilities) }}</textarea></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4"><label class="form-label">Salary Scale</label><input type="text" name="salary_scale" class="form-control" value="{{ old('salary_scale',$vacancy->salary_scale) }}"></div>
                    <div class="col-md-4"><label class="form-label">Duty Station</label><input type="text" name="duty_station" class="form-control" value="{{ old('duty_station',$vacancy->duty_station) }}"></div>
                    <div class="col-md-4"><label class="form-label">No. of Posts</label><input type="number" name="vacancies_count" class="form-control" value="{{ old('vacancies_count',$vacancy->vacancies_count??1) }}" min="1"></div>
                </div>
                <div class="mb-3"><label class="form-label">How to Apply</label><textarea name="application_method" class="form-control" rows="3">{{ old('application_method',$vacancy->application_method) }}</textarea></div>
                <div class="mb-3"><label class="form-label">Attachments</label><input type="file" name="attachments[]" class="form-control" multiple></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Status *</label><select name="status" class="form-select">@foreach(['open','closed','filled'] as $s)<option value="{{ $s }}" {{ old('status',$vacancy->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Published Date *</label><input type="date" name="published_date" class="form-control" value="{{ old('published_date',$vacancy->published_date?->format('Y-m-d')) }}" required></div>
                <div class="mb-3"><label class="form-label">Closing Date *</label><input type="date" name="closing_date" class="form-control" value="{{ old('closing_date',$vacancy->closing_date?->format('Y-m-d')) }}" required></div>
                <div class="mb-3"><label class="form-label">Application Email</label><input type="email" name="application_email" class="form-control" value="{{ old('application_email',$vacancy->application_email) }}"></div>
                <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active',$vacancy->is_active??true)?'checked':'' }}><label class="form-check-label">Active</label></div>
                <div class="d-grid"><button type="submit" class="btn btn-primary">{{ $vacancy->exists ? 'Update' : 'Create' }}</button></div>
                <a href="{{ route('admin.vacancies.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
