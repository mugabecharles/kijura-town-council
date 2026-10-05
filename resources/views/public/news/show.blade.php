@extends('layouts.public')
@section('meta_title', $news->meta_title ?: $news->title . ' — Kijura Town Council')
@section('meta_description', $news->meta_description ?: $news->excerpt)
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('news.index') }}">News</a></li><li class="breadcrumb-item active">{{ Str::limit($news->title,40) }}</li></ol></nav></div></div>
<section class="section-pad"><div class="container">
<div class="row g-5">
<div class="col-lg-8">
    @if($news->featured_image)<img src="{{ asset('storage/'.$news->featured_image) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $news->title }}" style="max-height:420px;object-fit:cover">@endif
    @if($news->category)<span class="card-tag mb-3 d-inline-block" style="background:{{ $news->category->color }}">{{ $news->category->name }}</span>@endif
    <h1 class="mb-3 fs-2">{{ $news->title }}</h1>
    <div class="d-flex gap-3 text-muted small mb-4 flex-wrap">
        <span><i class="bi bi-calendar3 me-1"></i>{{ $news->published_at?->format('d M Y') }}</span>
        @if($news->author)<span><i class="bi bi-person me-1"></i>{{ $news->author->name }}</span>@endif
        <span><i class="bi bi-eye me-1"></i>{{ $news->views }} views</span>
    </div>
    <div class="prose" style="line-height:1.8">{!! nl2br(e($news->content)) !!}</div>
    @if($news->attachments->isNotEmpty())
    <div class="mt-4 p-3 bg-light rounded">
        <h6 class="fw-bold mb-3"><i class="bi bi-paperclip me-2"></i>Attachments</h6>
        @foreach($news->attachments as $att)
        <a href="{{ asset('storage/'.$att->file_path) }}" class="d-flex align-items-center mb-2 text-decoration-none" download>
            <i class="bi bi-file-earmark me-2 text-ktc fs-5"></i>
            <span class="text-dark">{{ $att->name }}</span>
        </a>
        @endforeach
    </div>
    @endif
</div>
<div class="col-lg-4">
    @if($related->isNotEmpty())
    <div class="ktc-card card p-3">
        <h6 class="fw-bold mb-3">Related Articles</h6>
        @foreach($related as $r)
        <div class="mb-3 pb-3 border-bottom">
            <a href="{{ route('news.show',$r->slug) }}" class="text-decoration-none text-dark fw-semibold small">{{ $r->title }}</a>
            <div class="text-muted x-small mt-1">{{ $r->published_at?->format('d M Y') }}</div>
        </div>
        @endforeach
    </div>
    @endif
</div>
</div>
</div></section>
@endsection
