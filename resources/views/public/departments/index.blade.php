@extends('layouts.public')
@section('meta_title','Departments — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Departments</li></ol></nav><h1 class="mt-2">Council Departments</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-4">
@forelse($departments as $dept)
<div class="col-md-6 col-lg-4">
    <a href="{{ route('departments.show',$dept->slug) }}" class="text-decoration-none">
        <div class="service-card h-100">
            <div class="service-icon"><i class="bi {{ $dept->icon ?: 'bi-building' }}"></i></div>
            <h5>{{ $dept->name }}</h5>
            @if($dept->head_name)<div class="small text-muted mb-1"><i class="bi bi-person me-1"></i>{{ $dept->head_name }}</div>@endif
            @if($dept->description)<p class="text-muted small mb-0">{{ Str::limit($dept->description,100) }}</p>@endif
        </div>
    </a>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><p>Department information will be published here.</p></div>@endforelse
</div>
</div></section>
@endsection
