@extends('layouts.public')
@section('meta_title','Documents & Publications — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Documents</li></ol></nav><h1 class="mt-2">Documents &amp; Publications</h1></div></div>
<section class="section-pad"><div class="container">
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-3"><select name="category" class="form-select"><option value="">All Categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><select name="year" class="form-select"><option value="">All Years</option>@foreach($years as $y)<option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>{{ $y }}</option>@endforeach</select></div>
    <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search documents…" value="{{ request('search') }}"></div>
    <div class="col-auto"><button class="btn btn-ktc-primary">Search</button></div>
</form>
<div class="row g-3">
@forelse($documents as $doc)
<div class="col-12">
    <div class="document-item">
        <div class="document-icon"><i class="bi {{ $doc->file_icon }}"></i></div>
        <div class="flex-grow-1">
            <div class="fw-semibold">{{ $doc->title }}</div>
            <div class="small text-muted">{{ $doc->category?->name }} @if($doc->year) · {{ $doc->year }}@endif @if($doc->department) · {{ $doc->department->name }}@endif</div>
            @if($doc->description)<div class="small text-muted mt-1">{{ Str::limit($doc->description,120) }}</div>@endif
        </div>
        <div class="ms-3 text-end flex-shrink-0">
            <div class="small text-muted mb-1">{{ $doc->file_size_formatted }}</div>
            <a href="{{ route('documents.download',$doc->id) }}" class="btn btn-sm btn-ktc-primary"><i class="bi bi-download me-1"></i>Download</a>
        </div>
    </div>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-folder" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No documents found.</p></div>@endforelse
</div>
<div class="mt-4">{{ $documents->links() }}</div>
</div></section>
@endsection
