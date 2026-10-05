@extends('layouts.public')
@section('meta_title', $department->name . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li><li class="breadcrumb-item active">{{ $department->name }}</li></ol></nav><h1 class="mt-2">{{ $department->name }}</h1></div></div>
<section class="section-pad"><div class="container"><div class="row g-5">
<div class="col-lg-8">
    @if($department->description)<p class="lead">{{ $department->description }}</p>@endif
    @if($department->services->isNotEmpty())
    <h4 class="mt-4 mb-3">Services</h4>
    <div class="row g-3">
    @foreach($department->services as $s)
    <div class="col-md-6"><a href="{{ route('services.show',$s->slug) }}" class="text-decoration-none"><div class="service-card"><div class="service-icon"><i class="bi {{ $s->icon ?: 'bi-gear' }}"></i></div><h6>{{ $s->name }}</h6><p class="text-muted small mb-0">{{ Str::limit($s->description,80) }}</p></div></a></div>
    @endforeach
    </div>
    @endif
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3">
        <h6 class="fw-bold mb-3">Contact</h6>
        <dl class="small mb-0">
            @if($department->head_name)<dt>Head of Department</dt><dd class="text-muted">{{ $department->head_name }}@if($department->head_title), {{ $department->head_title }}@endif</dd>@endif
            @if($department->phone)<dt>Phone</dt><dd class="text-muted">{{ $department->phone }}</dd>@endif
            @if($department->email)<dt>Email</dt><dd class="text-muted"><a href="mailto:{{ $department->email }}">{{ $department->email }}</a></dd>@endif
            @if($department->location)<dt>Location</dt><dd class="text-muted">{{ $department->location }}</dd>@endif
        </dl>
    </div>
</div>
</div></div></section>
@endsection
