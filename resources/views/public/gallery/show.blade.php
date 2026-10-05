@extends('layouts.public')
@section('meta_title', $galleryAlbum->name . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Gallery</a></li><li class="breadcrumb-item active">{{ $galleryAlbum->name }}</li></ol></nav><h1 class="mt-2">{{ $galleryAlbum->name }}</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-2">
@forelse($galleryAlbum->images as $img)
<div class="col-6 col-md-4 col-lg-3">
    <div class="gallery-thumb" data-full="{{ asset('storage/'.$img->image) }}" data-caption="{{ $img->caption }}">
        <img src="{{ asset('storage/'.$img->image) }}" alt="{{ $img->alt_text ?: $galleryAlbum->name }}" loading="lazy">
    </div>
    @if($img->caption)<p class="small text-muted mt-1 mb-0">{{ $img->caption }}</p>@endif
</div>
@empty<div class="col-12 text-center py-5 text-muted"><p>No photos in this album yet.</p></div>@endforelse
</div>
</div></section>

<div class="modal fade" id="lightboxModal" tabindex="-1"><div class="modal-dialog modal-xl modal-dialog-centered"><div class="modal-content bg-dark border-0"><div class="modal-header border-0 pb-0"><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body text-center p-2"><img id="lightboxImg" src="" class="img-fluid" alt=""><p id="lightboxCaption" class="text-white mt-2 small"></p></div></div></div></div>
@endsection
