@extends('layouts.public')
@section('meta_title', 'Location & Map — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('about.index') }}">About</a></li><li class="breadcrumb-item active">Location</li></ol></nav><h1 class="mt-2">Location &amp; Map</h1></div></div>
<section class="section-pad"><div class="container">
<div class="row g-5 align-items-start">
<div class="col-lg-5">
<h2 class="mb-3">How to Find Us</h2>
<p>Kijura Town Council is located in Burahya County, Kabarole District, approximately 30 km north-east of Fort Portal City along the Fort Portal–Mubende Highway.</p>
<dl class="mt-4">
<dt><i class="bi bi-geo-alt-fill text-ktc me-2"></i>Address</dt><dd class="ms-4 mb-3 text-muted">Kijura Town Council, Burahya County, Kabarole District, Western Uganda</dd>
<dt><i class="bi bi-compass text-ktc me-2"></i>Coordinates</dt><dd class="ms-4 mb-3 text-muted">0°49'01"N, 30°25'03"E</dd>
<dt><i class="bi bi-mountain text-ktc me-2"></i>Elevation</dt><dd class="ms-4 mb-3 text-muted">Approximately 1,513 metres above sea level</dd>
<dt><i class="bi bi-telephone-fill text-ktc me-2"></i>Phone</dt><dd class="ms-4 mb-3 text-muted">{{ \App\Models\Setting::get('site_phone','+256 XXX XXX XXX') }}</dd>
<dt><i class="bi bi-envelope-fill text-ktc me-2"></i>Email</dt><dd class="ms-4 mb-3 text-muted">{{ \App\Models\Setting::get('site_email','info@kijuratowncouncil.go.ug') }}</dd>
</dl>
</div>
<div class="col-lg-7">
<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">
    <div class="text-center text-muted p-4">
        <i class="bi bi-map" style="font-size:4rem;opacity:.25"></i>
        <p class="mt-3">Interactive map will appear here.<br>Configure the embed URL in <strong>Admin → Settings → Contact</strong>.</p>
        <a href="https://www.openstreetmap.org/?mlat=0.8169&mlon=30.4175#map=14/0.8169/30.4175" class="btn btn-ktc-outline btn-sm mt-2" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right me-1"></i>View on OpenStreetMap</a>
    </div>
</div>
</div>
</div>
</div></section>
@endsection
