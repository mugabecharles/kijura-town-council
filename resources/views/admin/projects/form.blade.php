@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'New Project')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">{{ $project->exists ? 'Edit' : 'New' }}</li>
@endsection
@section('content')
<form action="{{ $project->exists ? route('admin.projects.update',$project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf @if($project->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="mb-3"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title',$project->title) }}" required></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4"><label class="form-label">Project Code</label><input type="text" name="code" class="form-control" value="{{ old('code',$project->code) }}"></div>
                    <div class="col-md-4"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">— None —</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id',$project->department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Ward</label><select name="ward_id" class="form-select"><option value="">— None —</option>@foreach($wards as $w)<option value="{{ $w->id }}" {{ old('ward_id',$project->ward_id)==$w->id?'selected':'' }}>{{ $w->name }}</option>@endforeach</select></div>
                </div>
                <div class="mb-3"><label class="form-label">Location</label><input type="text" name="location" class="form-control" value="{{ old('location',$project->location) }}"></div>
                <div class="mb-3"><label class="form-label">Description *</label><textarea name="description" class="form-control" rows="3" required>{{ old('description',$project->description) }}</textarea></div>
                <div class="mb-3"><label class="form-label">Full Description</label><textarea name="full_description" class="form-control" rows="8">{{ old('full_description',$project->full_description) }}</textarea></div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Budget (UGX)</label><input type="number" name="budget" class="form-control" value="{{ old('budget',$project->budget) }}"></div>
                    <div class="col-md-6"><label class="form-label">Funding Source</label><input type="text" name="funding_source" class="form-control" value="{{ old('funding_source',$project->funding_source) }}"></div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label">Contractor</label><input type="text" name="contractor" class="form-control" value="{{ old('contractor',$project->contractor) }}"></div>
                    <div class="col-md-6"><label class="form-label">Contractor Contact</label><input type="text" name="contractor_contact" class="form-control" value="{{ old('contractor_contact',$project->contractor_contact) }}"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="mb-3"><label class="form-label">Status *</label><select name="status" class="form-select">@foreach(['planned','procurement','ongoing','completed','delayed','suspended'] as $s)<option value="{{ $s }}" {{ old('status',$project->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Progress %</label><input type="number" name="progress_percent" class="form-control" min="0" max="100" value="{{ old('progress_percent',$project->progress_percent ?? 0) }}"></div>
                <div class="mb-3"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date',$project->start_date?->format('Y-m-d')) }}"></div>
                <div class="mb-3"><label class="form-label">Expected Completion</label><input type="date" name="expected_completion" class="form-control" value="{{ old('expected_completion',$project->expected_completion?->format('Y-m-d')) }}"></div>
                <div class="mb-3"><label class="form-label">Actual Completion</label><input type="date" name="actual_completion" class="form-control" value="{{ old('actual_completion',$project->actual_completion?->format('Y-m-d')) }}"></div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="isFeat" value="1" {{ old('is_featured',$project->is_featured)?'checked':'' }}>
                    <label class="form-check-label" for="isFeat">Featured on Homepage</label>
                </div>
            </div>
            <div class="admin-card">
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    @if($project->featured_image)<img src="{{ asset('storage/'.$project->featured_image) }}" class="img-fluid rounded mb-2 d-block" id="imgPreview" style="max-height:120px">@else<img id="imgPreview" src="" class="img-fluid rounded mb-2 d-none" style="max-height:120px">@endif
                    <input type="file" name="featured_image" class="form-control" accept="image/*" data-preview="imgPreview">
                </div>
                <div class="mb-3"><label class="form-label">Gallery Images</label><input type="file" name="images[]" class="form-control" accept="image/*" multiple></div>
                <div class="mb-3"><label class="form-label">GPS Latitude</label><input type="text" name="latitude" class="form-control" value="{{ old('latitude',$project->latitude) }}"></div>
                <div class="mb-3"><label class="form-label">GPS Longitude</label><input type="text" name="longitude" class="form-control" value="{{ old('longitude',$project->longitude) }}"></div>
                <div class="d-grid"><button type="submit" class="btn btn-primary">{{ $project->exists ? 'Update' : 'Create' }}</button></div>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
