@extends('layouts.public')
@section('meta_title','Track Submission — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><h1 class="mt-2">Track Your Submission</h1></div></div>
<section class="section-pad"><div class="container"><div class="row justify-content-center"><div class="col-lg-6">
<div class="ktc-card card p-4 mb-4">
<h5 class="fw-bold mb-3">Enter your reference number</h5>
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<form method="POST" action="{{ route('feedback.track') }}">
    @csrf
    <div class="input-group">
        <input type="text" name="reference_number" class="form-control" placeholder="e.g. KTC-FB-2026-00001" value="{{ old('reference_number') }}" required>
        <button class="btn btn-ktc-primary" type="submit"><i class="bi bi-search me-1"></i>Track</button>
    </div>
</form>
</div>

@if(isset($feedback) && $feedback)
<div class="ktc-card card p-4">
<h5 class="fw-bold mb-3">{{ $feedback->reference_number }}</h5>
<div class="mb-3"><strong>Subject:</strong> {{ $feedback->subject }}</div>
<div class="mb-3"><strong>Type:</strong> {{ $feedback->type_label }}</div>
<div class="mb-3"><strong>Status:</strong> <span class="badge bg-{{ $feedback->status_color }} fs-6">{{ $feedback->status_label }}</span></div>
<div class="mb-3"><strong>Submitted:</strong> {{ $feedback->created_at->format('d M Y') }}</div>
@if($feedback->resolution)<div class="alert alert-success mt-3"><strong>Resolution:</strong> {{ $feedback->resolution }}</div>@endif
</div>
@endif

<div class="text-center mt-3"><a href="{{ route('feedback.index') }}" class="small text-ktc">Submit new feedback</a></div>
</div></div></div></section>
@endsection
