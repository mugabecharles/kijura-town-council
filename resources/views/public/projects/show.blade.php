@extends('layouts.public')
@section('meta_title', ($project->meta_title ?: $project->title) . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li><li class="breadcrumb-item active">{{ Str::limit($project->title,40) }}</li></ol></nav><h1 class="mt-2">{{ $project->title }}</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-5">
<div class="col-lg-8">
    @if($project->featured_image)<img src="{{ asset('storage/'.$project->featured_image) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $project->title }}" style="max-height:420px;object-fit:cover">@endif
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <span class="badge bg-{{ $project->status_color }} fs-6">{{ $project->status_label }}</span>
        @if($project->department)<span class="badge bg-light text-dark">{{ $project->department->name }}</span>@endif
        @if($project->ward)<span class="badge bg-light text-dark">{{ $project->ward->name }} Ward</span>@endif
    </div>
    <p class="lead mb-3">{{ $project->description }}</p>
    @if($project->full_description)<div class="mb-4" style="line-height:1.8">{!! nl2br(e($project->full_description)) !!}</div>@endif
    <h5 class="mb-3">Progress</h5>
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="project-status-bar flex-grow-1" style="height:12px"><div class="project-status-fill" style="width:{{ $project->progress_percent }}%"></div></div>
        <strong>{{ $project->progress_percent }}%</strong>
    </div>

    @if($project->images->isNotEmpty())
    <h5 class="mb-3">Project Gallery</h5>
    <div class="row g-2 mb-4">
        @foreach($project->images as $img)
        <div class="col-4 col-md-3"><div class="gallery-thumb" data-full="{{ asset('storage/'.$img->image) }}" data-caption="{{ $img->caption }}"><img src="{{ asset('storage/'.$img->image) }}" alt="{{ $img->alt_text ?: $project->title }}" loading="lazy"></div></div>
        @endforeach
    </div>
    @endif

    @if($project->updates->isNotEmpty())
    <h5 class="mb-3">Project Updates</h5>
    @foreach($project->updates as $update)
    <div class="mb-3 p-3 bg-light rounded">
        <div class="d-flex justify-content-between mb-1"><strong class="small">{{ $update->title }}</strong><small class="text-muted">{{ $update->update_date->format('d M Y') }}</small></div>
        <p class="mb-0 small">{{ $update->description }}</p>
    </div>
    @endforeach
    @endif
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3 mb-3">
        <h6 class="fw-bold mb-3">Project Details</h6>
        <dl class="small mb-0">
            @if($project->code)<dt>Project Code</dt><dd class="text-muted">{{ $project->code }}</dd>@endif
            @if($project->location)<dt>Location</dt><dd class="text-muted">{{ $project->location }}</dd>@endif
            @if($project->budget)<dt>Budget</dt><dd class="text-muted">UGX {{ number_format($project->budget) }}</dd>@endif
            @if($project->funding_source)<dt>Funding Source</dt><dd class="text-muted">{{ $project->funding_source }}</dd>@endif
            @if($project->contractor)<dt>Contractor</dt><dd class="text-muted">{{ $project->contractor }}</dd>@endif
            @if($project->start_date)<dt>Start Date</dt><dd class="text-muted">{{ $project->start_date->format('d M Y') }}</dd>@endif
            @if($project->expected_completion)<dt>Expected Completion</dt><dd class="text-muted">{{ $project->expected_completion->format('d M Y') }}</dd>@endif
        </dl>
    </div>
    @if($related->isNotEmpty())
    <div class="ktc-card card p-3">
        <h6 class="fw-bold mb-3">Related Projects</h6>
        @foreach($related as $r)
        <div class="mb-2 pb-2 border-bottom"><a href="{{ route('projects.show',$r->slug) }}" class="text-decoration-none text-dark small fw-semibold">{{ $r->title }}</a><div class="x-small text-muted"><span class="badge bg-{{ $r->status_color }}">{{ $r->status_label }}</span></div></div>
        @endforeach
    </div>
    @endif
</div>
</div>
</div></section>

<div class="modal fade" id="lightboxModal" tabindex="-1"><div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content bg-dark border-0"><div class="modal-header border-0 pb-0"><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body text-center p-2"><img id="lightboxImg" src="" class="img-fluid"><p id="lightboxCaption" class="text-white mt-2 small"></p></div></div></div></div>
@endsection
