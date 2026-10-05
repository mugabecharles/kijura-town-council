@extends('layouts.public')
@section('meta_title','Services — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Services</li></ol></nav><h1 class="mt-2">Council Services</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-4">
@forelse($services as $service)
<div class="col-md-6 col-lg-4">
    <a href="{{ route('services.show',$service->slug) }}" class="text-decoration-none">
        <div class="service-card h-100">
            <div class="service-icon"><i class="bi {{ $service->icon ?: 'bi-gear' }}"></i></div>
            <h5>{{ $service->name }}</h5>
            <p class="text-muted small mb-2">{{ Str::limit($service->description,100) }}</p>
            @if($service->fee)<div class="small text-muted"><i class="bi bi-cash-coin me-1"></i>{{ $service->fee }}</div>@endif
            @if($service->duration)<div class="small text-muted"><i class="bi bi-clock me-1"></i>{{ $service->duration }}</div>@endif
            <span class="text-ktc small mt-2 d-block">Learn more <i class="bi bi-arrow-right ms-1"></i></span>
        </div>
    </a>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><p>Services information will be published here.</p></div>@endforelse
</div>
</div></section>
@endsection
