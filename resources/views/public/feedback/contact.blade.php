@extends('layouts.public')
@section('meta_title','Contact Us — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Contact</li></ol></nav><h1 class="mt-2">Contact Us</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-5">
<div class="col-lg-5">
<h3 class="mb-4">Get in Touch</h3>
<ul class="list-unstyled">
<li class="d-flex mb-4"><div class="me-3 text-ktc fs-3"><i class="bi bi-geo-alt-fill"></i></div><div><strong>Address</strong><br><span class="text-muted">Kijura Town Council, Burahya County, Kabarole District, Western Uganda</span></div></li>
<li class="d-flex mb-4"><div class="me-3 text-ktc fs-3"><i class="bi bi-telephone-fill"></i></div><div><strong>Phone</strong><br><span class="text-muted">{{ \App\Models\Setting::get('site_phone','+256 XXX XXX XXX') }}</span></div></li>
<li class="d-flex mb-4"><div class="me-3 text-ktc fs-3"><i class="bi bi-envelope-fill"></i></div><div><strong>Email</strong><br><span class="text-muted">{{ \App\Models\Setting::get('site_email','info@kijuratowncouncil.go.ug') }}</span></div></li>
<li class="d-flex mb-4"><div class="me-3 text-ktc fs-3"><i class="bi bi-clock-fill"></i></div><div><strong>Office Hours</strong><br><span class="text-muted">Monday – Friday: 8:00 AM – 5:00 PM</span></div></li>
</ul>
<a href="{{ route('feedback.index') }}" class="btn btn-ktc-primary"><i class="bi bi-chat-dots me-2"></i>Submit Formal Feedback</a>
</div>
<div class="col-lg-7">
<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">
<div class="text-center text-muted p-4"><i class="bi bi-map" style="font-size:4rem;opacity:.25"></i><p class="mt-3">Map embed configured in Admin → Settings</p><a href="https://www.openstreetmap.org/?mlat=0.8169&mlon=30.4175#map=14/0.8169/30.4175" class="btn btn-ktc-outline btn-sm mt-2" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right me-1"></i>Open in OpenStreetMap</a></div>
</div>
</div>
</div>
</div></section>
@endsection
