@extends('layouts.public')
@section('meta_title', $vacancy->title . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('vacancies.index') }}">Vacancies</a></li><li class="breadcrumb-item active">{{ Str::limit($vacancy->title,40) }}</li></ol></nav><h1 class="mt-2">{{ $vacancy->title }}</h1></div></div>
<section class="section-pad"><div class="container"><div class="row g-5">
<div class="col-lg-8">
    <div class="mb-4 p-3 bg-light rounded">
        <div class="row g-3 small">
            <div class="col-sm-4"><strong>Type</strong><br>{{ $vacancy->type_label }}</div>
            @if($vacancy->department)<div class="col-sm-4"><strong>Department</strong><br>{{ $vacancy->department->name }}</div>@endif
            @if($vacancy->duty_station)<div class="col-sm-4"><strong>Duty Station</strong><br>{{ $vacancy->duty_station }}</div>@endif
            @if($vacancy->salary_scale)<div class="col-sm-4"><strong>Salary Scale</strong><br>{{ $vacancy->salary_scale }}</div>@endif
            <div class="col-sm-4"><strong>Posts</strong><br>{{ $vacancy->vacancies_count }}</div>
            <div class="col-sm-4"><strong>Deadline</strong><br><span class="{{ $vacancy->closing_date < now()?'text-danger fw-bold':'text-dark' }}">{{ $vacancy->closing_date->format('d M Y') }}</span></div>
        </div>
    </div>
    <div class="mb-4">{!! nl2br(e($vacancy->description)) !!}</div>
    @if($vacancy->requirements)<h5>Requirements</h5><div class="mb-4">{!! nl2br(e($vacancy->requirements)) !!}</div>@endif
    @if($vacancy->responsibilities)<h5>Responsibilities</h5><div class="mb-4">{!! nl2br(e($vacancy->responsibilities)) !!}</div>@endif
    @if($vacancy->application_method)<div class="alert alert-success mt-4"><h5><i class="bi bi-envelope me-2"></i>How to Apply</h5><p class="mb-0">{!! nl2br(e($vacancy->application_method)) !!}</p></div>@endif
    @if($vacancy->attachments->isNotEmpty())
    <div class="p-3 bg-light rounded mt-4"><h5 class="mb-3">Attachments</h5>@foreach($vacancy->attachments as $att)<a href="{{ asset('storage/'.$att->file_path) }}" class="d-flex align-items-center mb-2 text-decoration-none" download><i class="bi bi-file-earmark me-2 text-ktc fs-5"></i><span class="text-dark">{{ $att->name }}</span></a>@endforeach</div>
    @endif
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3">
        <a href="{{ route('vacancies.index') }}" class="btn btn-ktc-outline w-100 mb-3">← All Vacancies</a>
        @if($vacancy->application_email)<a href="mailto:{{ $vacancy->application_email }}" class="btn btn-ktc-primary w-100"><i class="bi bi-envelope me-2"></i>Apply by Email</a>@endif
    </div>
</div>
</div></div></section>
@endsection
