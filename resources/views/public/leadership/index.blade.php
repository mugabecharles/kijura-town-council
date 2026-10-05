@extends('layouts.public')
@section('meta_title','Leadership — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Leadership</li></ol></nav><h1 class="mt-2">Council Leadership</h1></div></div>
<section class="section-pad"><div class="container">

@if($political->isNotEmpty())
<h3 class="mb-4 fw-bold">Political Leadership</h3>
<div class="row g-4 mb-5">
@foreach($political as $l)
<div class="col-md-4 col-lg-3">
<div class="leader-card">
@if($l->photo)<img src="{{ asset('storage/'.$l->photo) }}" class="leader-photo" alt="{{ $l->name }}">@else<div class="leader-photo-placeholder"><i class="bi bi-person-fill"></i></div>@endif
<h5 class="mb-1">{{ $l->name }}</h5>
<div class="leader-title mb-2">{{ $l->title }}</div>
@if($l->phone)<div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $l->phone }}</div>@endif
</div>
</div>
@endforeach
</div>
@endif

@if($technical->isNotEmpty())
<h3 class="mb-4 fw-bold">Technical Management</h3>
<div class="row g-4 mb-5">
@foreach($technical as $l)
<div class="col-md-4 col-lg-3">
<div class="leader-card">
@if($l->photo)<img src="{{ asset('storage/'.$l->photo) }}" class="leader-photo" alt="{{ $l->name }}">@else<div class="leader-photo-placeholder"><i class="bi bi-person-fill"></i></div>@endif
<h5 class="mb-1">{{ $l->name }}</h5>
<div class="leader-title mb-2">{{ $l->title }}</div>
</div>
</div>
@endforeach
</div>
@endif

@if($councilors->isNotEmpty())
<h3 class="mb-4 fw-bold">Ward Councilors</h3>
<div class="row g-4 mb-5">
@foreach($councilors as $l)
<div class="col-md-4 col-lg-3">
<div class="leader-card">
@if($l->photo)<img src="{{ asset('storage/'.$l->photo) }}" class="leader-photo" alt="{{ $l->name }}">@else<div class="leader-photo-placeholder"><i class="bi bi-person-fill"></i></div>@endif
<h5 class="mb-1">{{ $l->name }}</h5>
<div class="leader-title mb-1">{{ $l->title }}</div>
@if($l->ward)<div class="small text-ktc">{{ $l->ward->name }} Ward</div>@endif
</div>
</div>
@endforeach
</div>
@endif

@if($hods->isNotEmpty())
<h3 class="mb-4 fw-bold">Heads of Departments</h3>
<div class="row g-4">
@foreach($hods as $l)
<div class="col-md-4 col-lg-3">
<div class="leader-card">
@if($l->photo)<img src="{{ asset('storage/'.$l->photo) }}" class="leader-photo" alt="{{ $l->name }}">@else<div class="leader-photo-placeholder"><i class="bi bi-person-fill"></i></div>@endif
<h5 class="mb-1">{{ $l->name }}</h5>
<div class="leader-title mb-1">{{ $l->title }}</div>
@if($l->department)<div class="small text-ktc">{{ $l->department->name }}</div>@endif
</div>
</div>
@endforeach
</div>
@endif

@if($political->isEmpty() && $technical->isEmpty() && $councilors->isEmpty() && $hods->isEmpty())
<div class="text-center py-5 text-muted"><i class="bi bi-person-badge" style="font-size:4rem;opacity:.2"></i><p class="mt-3">Leadership profiles will be published here once verified by the council.</p></div>
@endif

</div></section>
@endsection
