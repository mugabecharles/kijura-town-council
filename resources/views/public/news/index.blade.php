@extends('layouts.public')
@section('meta_title', ucfirst($type) . 's — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">{{ ucfirst($type) }}s</li></ol></nav><h1 class="mt-2">{{ ucfirst($type) === 'News' ? 'Latest News' : ucfirst($type).'s' }}</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-4">
<div class="col-lg-8">
    <form class="mb-4" method="GET">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="input-group"><input type="text" name="search" class="form-control" placeholder="Search…" value="{{ request('search') }}"><button class="btn btn-ktc-primary"><i class="bi bi-search"></i></button></div>
    </form>
    <div class="row g-4">
    @forelse($news as $article)
    <div class="col-md-6">
        <div class="ktc-card card h-100">
            @if($article->featured_image)<img src="{{ asset('storage/'.$article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" loading="lazy" style="height:180px;object-fit:cover">@else<div class="bg-light d-flex align-items-center justify-content-center" style="height:180px"><i class="bi bi-newspaper text-muted" style="font-size:2.5rem"></i></div>@endif
            <div class="card-body">
                @if($article->category)<span class="card-tag" style="background:{{ $article->category->color }}">{{ $article->category->name }}</span>@endif
                <h5 class="mt-1 fs-6 fw-semibold"><a href="{{ route('news.show',$article->slug) }}" class="text-decoration-none text-dark stretched-link">{{ $article->title }}</a></h5>
                @if($article->excerpt)<p class="text-muted small">{{ Str::limit($article->excerpt,100) }}</p>@endif
                <div class="card-date mt-auto"><i class="bi bi-calendar3 me-1"></i>{{ $article->published_at?->format('d M Y') }}</div>
            </div>
        </div>
    </div>
    @empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-newspaper" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No articles published yet.</p></div>@endforelse
    </div>
    <div class="mt-4">{{ $news->links() }}</div>
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3 mb-4">
        <h6 class="fw-bold mb-3">Filter by Type</h6>
        @foreach(['news'=>'News','announcement'=>'Announcements','event'=>'Events','press_release'=>'Press Releases'] as $t=>$l)
        <a href="{{ route('news.index',['type'=>$t]) }}" class="d-block py-1 px-2 rounded text-decoration-none mb-1 {{ $type===$t?'bg-ktc text-white':'text-dark hover' }}">{{ $l }}</a>
        @endforeach
    </div>
    <div class="ktc-card card p-3">
        <h6 class="fw-bold mb-3">Categories</h6>
        @foreach($categories as $cat)
        <a href="{{ route('news.index',['category'=>$cat->id,'type'=>$type]) }}" class="d-flex justify-content-between align-items-center py-1 px-2 rounded text-decoration-none text-dark mb-1">
            <span>{{ $cat->name }}</span><span class="badge bg-light text-dark">{{ $cat->news_count }}</span>
        </a>
        @endforeach
    </div>
</div>
</div>
</div></section>
@endsection
