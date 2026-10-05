@extends('layouts.public')
@section('meta_title','Tenders & Procurement — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Tenders</li></ol></nav><h1 class="mt-2">Tenders &amp; Procurement</h1></div></div>
<section class="section-pad"><div class="container">
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-3"><select name="status" class="form-select"><option value="">All Statuses</option>@foreach(['open','closed','cancelled','awarded'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
    <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search by title or reference number…" value="{{ request('search') }}"></div>
    <div class="col-auto"><button class="btn btn-ktc-primary">Search</button></div>
</form>
<div class="row g-3">
@forelse($tenders as $tender)
<div class="col-12">
    <div class="opportunity-item">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <span class="badge bg-{{ $tender->status_color }} me-2">{{ ucfirst($tender->status) }}</span>
                <h5 class="mt-2 mb-1"><a href="{{ route('tenders.show',$tender->slug) }}" class="text-decoration-none text-dark">{{ $tender->title }}</a></h5>
                <div class="small text-muted">Ref: {{ $tender->reference_number }} @if($tender->department) | {{ $tender->department->name }}@endif</div>
                <div class="small text-muted mt-1">Published: {{ $tender->published_date->format('d M Y') }} | <span class="{{ $tender->is_expired?'deadline-warning':'text-muted' }}">Closes: {{ $tender->closing_date->format('d M Y') }}</span></div>
            </div>
            <a href="{{ route('tenders.show',$tender->slug) }}" class="btn btn-sm btn-ktc-outline ms-3 flex-shrink-0">View Details</a>
        </div>
    </div>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-clipboard-check" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No tenders available.</p></div>@endforelse
</div>
<div class="mt-4">{{ $tenders->links() }}</div>
</div></section>
@endsection
