@extends('layouts.public')
@section('meta_title','Development Projects — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Projects</li></ol></nav><h1 class="mt-2">Development Projects</h1></div></div>
<section class="section-pad"><div class="container">
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-3"><select name="status" class="form-select"><option value="">All Statuses</option>@foreach(['planned','procurement','ongoing','completed','delayed','suspended'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
    <div class="col-md-3"><select name="department" class="form-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
    <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search projects…" value="{{ request('search') }}"></div>
    <div class="col-auto"><button class="btn btn-ktc-primary">Filter</button></div>
</form>
<div class="row g-4">
@forelse($projects as $project)
<div class="col-md-6 col-lg-4">
    <div class="ktc-card card h-100">
        @if($project->featured_image)<img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top" alt="{{ $project->title }}" loading="lazy" style="height:200px;object-fit:cover">@else<div class="bg-light d-flex align-items-center justify-content-center" style="height:200px"><i class="bi bi-building text-muted" style="font-size:3rem"></i></div>@endif
        <div class="card-body d-flex flex-column">
            <span class="badge bg-{{ $project->status_color }} mb-2 align-self-start">{{ $project->status_label }}</span>
            <h5 class="card-title">{{ $project->title }}</h5>
            <p class="text-muted small flex-grow-1">{{ Str::limit($project->description,100) }}</p>
            <div class="project-status-bar mb-1"><div class="project-status-fill" style="width:{{ $project->progress_percent }}%"></div></div>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $project->progress_percent }}% complete</small>
                <a href="{{ route('projects.show',$project->slug) }}" class="btn btn-sm btn-ktc-primary">Details</a>
            </div>
        </div>
    </div>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-building" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No projects found.</p></div>@endforelse
</div>
<div class="mt-4">{{ $projects->links() }}</div>
</div></section>
@endsection
