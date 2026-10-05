@extends('layouts.public')
@section('meta_title', 'Search Results — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><h1 class="mt-2">Search Results</h1></div></div>
<section class="section-pad"><div class="container">
<form class="mb-4" method="GET" action="{{ route('search') }}">
    <div class="input-group input-group-lg"><input type="search" name="q" class="form-control" value="{{ $query }}" placeholder="Search the website…"><button class="btn btn-ktc-primary"><i class="bi bi-search me-1"></i>Search</button></div>
</form>

@if($query)
<p class="text-muted mb-4">{{ $total }} result(s) for "<strong>{{ $query }}</strong>"</p>
@if($results->isNotEmpty())
<div class="ktc-card card">
@foreach($results as $result)
<div class="search-result-item">
    <div class="result-type mb-1"><i class="bi {{ $result['icon'] }} me-1"></i>{{ $result['type'] }}</div>
    <h5 class="mb-1 fs-6"><a href="{{ $result['url'] }}" class="text-decoration-none text-dark fw-semibold">{{ $result['title'] }}</a></h5>
    @if($result['date'])<div class="small text-muted">{{ $result['date'] }}</div>@endif
</div>
@endforeach
</div>
@else
<div class="text-center py-5 text-muted"><i class="bi bi-search" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No results found for "{{ $query }}".<br>Try different keywords or browse sections above.</p></div>
@endif
@endif
</div></section>
@endsection
