@extends('layouts.public')
@section('meta_title', 'Wards & Villages — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('about.index') }}">About</a></li><li class="breadcrumb-item active">Wards &amp; Villages</li></ol></nav><h1 class="mt-2">Wards &amp; Villages</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row mb-4"><div class="col-lg-8"><p class="lead">Kijura Town Council comprises four wards: <strong>Kahuna, Kijura, Kaisagara and Kyererezi</strong>. The official list of villages under each ward is subject to verification and approval by the council before final publication.</p></div></div>
<div class="row g-4">
@foreach($wards as $ward)
<div class="col-md-6">
    <div class="ktc-card card h-100">
        <div class="card-body">
            <h4 class="card-title text-ktc"><i class="bi bi-map me-2"></i>{{ $ward->name }} Ward</h4>
            @if($ward->councilor_name)<p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>Councilor: {{ $ward->councilor_name }}</p>@endif
            @if($ward->description)<p class="text-muted small">{{ $ward->description }}</p>@endif
            @if($ward->villages->isNotEmpty())
            <h6 class="mt-3 mb-2 fw-semibold">Villages</h6>
            <ul class="list-group list-group-flush">
                @foreach($ward->villages as $v)
                <li class="list-group-item px-0 py-1 small border-0"><i class="bi bi-geo-alt text-ktc me-2"></i>{{ $v->name }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endforeach
</div>
<div class="alert alert-warning mt-4"><i class="bi bi-exclamation-triangle me-2"></i>The village list shown is provisional. The official verified list will be published once approved by Kijura Town Council.</div>
</div></section>
@endsection
