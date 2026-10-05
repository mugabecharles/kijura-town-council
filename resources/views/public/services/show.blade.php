@extends('layouts.public')
@section('meta_title', $service->name . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li><li class="breadcrumb-item active">{{ $service->name }}</li></ol></nav><h1 class="mt-2">{{ $service->name }}</h1></div></div>
<section class="section-pad"><div class="container"><div class="row g-5">
<div class="col-lg-8">
    <p class="lead">{{ $service->description }}</p>
    @if($service->full_description)<div class="mt-3" style="line-height:1.8">{!! nl2br(e($service->full_description)) !!}</div>@endif
    @if($service->requirements)<div class="mt-4 p-3 bg-light rounded"><h5><i class="bi bi-list-check me-2"></i>Requirements</h5>{!! nl2br(e($service->requirements)) !!}</div>@endif
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3 mb-3">
        <h6 class="fw-bold mb-3">Service Information</h6>
        <dl class="small mb-0">
            @if($service->fee)<dt>Fee</dt><dd class="text-muted">{{ $service->fee }}</dd>@endif
            @if($service->duration)<dt>Processing Time</dt><dd class="text-muted">{{ $service->duration }}</dd>@endif
            @if($service->hours)<dt>Office Hours</dt><dd class="text-muted">{{ $service->hours }}</dd>@endif
            @if($service->location)<dt>Location</dt><dd class="text-muted">{{ $service->location }}</dd>@endif
            @if($service->contact_person)<dt>Contact</dt><dd class="text-muted">{{ $service->contact_person }}<br>@if($service->contact_phone){{ $service->contact_phone }}@endif</dd>@endif
            @if($service->department)<dt>Department</dt><dd class="text-muted">{{ $service->department->name }}</dd>@endif
        </dl>
    </div>
    <a href="{{ route('feedback.index') }}" class="btn btn-ktc-outline w-100"><i class="bi bi-chat-dots me-2"></i>Enquire About This Service</a>
</div>
</div></div></section>
@endsection
