@extends('layouts.public')
@section('meta_title','Submission Received — Kijura Town Council')
@section('content')
<section class="section-pad"><div class="container"><div class="row justify-content-center"><div class="col-lg-6 text-center">
<i class="bi bi-check-circle-fill text-success" style="font-size:5rem"></i>
<h2 class="mt-3 mb-2">Thank You!</h2>
<p class="text-muted mb-4">Your submission has been received. Please keep your reference number for tracking.</p>
@if($ref)<div class="ref-number mb-4">{{ $ref }}</div>@endif
<p class="text-muted small">Council staff will review your submission and respond within a reasonable time. You can track the status using the reference number above.</p>
<div class="d-flex gap-3 justify-content-center mt-4">
<a href="{{ route('feedback.track') }}" class="btn btn-ktc-primary">Track My Submission</a>
<a href="{{ route('home') }}" class="btn btn-ktc-outline">Back to Home</a>
</div>
</div></div></div></section>
@endsection
