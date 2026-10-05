@extends('layouts.public')
@section('meta_title','Photo Gallery — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Gallery</li></ol></nav><h1 class="mt-2">Photo Gallery</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-4">
@forelse($albums as $album)
<div class="col-md-4 col-lg-3">
    <a href="{{ route('gallery.show',$album->slug) }}" class="text-decoration-none">
        <div class="gallery-thumb mb-2">
            @if($album->cover_image)<img src="{{ asset('storage/'.$album->cover_image) }}" alt="{{ $album->name }}" loading="lazy">@else<div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;border-radius:6px"><i class="bi bi-images text-muted" style="font-size:2.5rem"></i></div>@endif
        </div>
        <div class="fw-semibold text-dark">{{ $album->name }}</div>
        <div class="small text-muted">{{ $album->images_count }} photos @if($album->event_date) · {{ $album->event_date->format('M Y') }}@endif</div>
    </a>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-camera" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No gallery albums yet.</p></div>@endforelse
</div>
<div class="mt-4">{{ $albums->links() }}</div>
</div></section>
@endsection
