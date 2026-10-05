@extends('layouts.public')
@section('meta_title', 'About Kijura Town Council')
@section('meta_description', 'Learn about Kijura Town Council — its history, vision, mission, wards and administrative structure.')

@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">About</li></ol></nav><h1 class="mt-2">About Kijura Town Council</h1></div></div>

<section class="section-pad">
<div class="container">
<div class="row g-5">
<div class="col-lg-7">
<h2 class="mb-3">Council Profile</h2>
<p>Kijura Town Council is located in Burahya County, Kabarole District, Western Uganda, approximately 30 km north-east of Fort Portal City along the Fort Portal–Mubende Highway. It was established on <strong>1 July 2010</strong>, carved out of Hakibale Sub-County, under the Local Government Act to bring services nearer to the people.</p>
<p>The council is home to tea-growing communities, TAMTECO and Kamusanga Tea Factories, and a vibrant trading centre. It comprises four wards: <strong>Kahuna, Kijura, Kaisagara and Kyererezi</strong>.</p>

<table class="table table-bordered table-sm mt-4">
<tbody>
<tr><th>Coordinates</th><td>0°49'01"N 30°25'03"E</td></tr>
<tr><th>Elevation</th><td>Approximately 1,513 metres</td></tr>
<tr><th>Operational Date</th><td>1 July 2010</td></tr>
<tr><th>Origin</th><td>Carved out of Hakibale Sub-County</td></tr>
<tr><th>Legal Basis</th><td>Local Government Act</td></tr>
<tr><th>Wards</th><td>Kahuna, Kijura, Kaisagara and Kyererezi</td></tr>
<tr><th>District</th><td>Kabarole District</td></tr>
<tr><th>County</th><td>Burahya County</td></tr>
<tr><th>Motto</th><td><strong>Together for Development</strong></td></tr>
</tbody>
</table>

<div class="row g-3 mt-3">
<div class="col-sm-4"><div class="text-center p-3 bg-light rounded"><div class="fs-3 fw-bold text-ktc">2010</div><div class="small text-muted">Established</div></div></div>
<div class="col-sm-4"><div class="text-center p-3 bg-light rounded"><div class="fs-3 fw-bold text-ktc">4</div><div class="small text-muted">Wards</div></div></div>
<div class="col-sm-4"><div class="text-center p-3 bg-light rounded"><div class="fs-3 fw-bold text-ktc">1,513m</div><div class="small text-muted">Elevation</div></div></div>
</div>
</div>
<div class="col-lg-5">
<div class="bg-light rounded p-4">
<h5 class="fw-bold text-ktc mb-3"><i class="bi bi-eye me-2"></i>Vision</h5>
<p class="mb-4">A well planned, economically vibrant and healthy Kijura Town Council.</p>
<h5 class="fw-bold text-ktc mb-3"><i class="bi bi-bullseye me-2"></i>Mission</h5>
<p class="mb-4">To provide quality services equitably and improve livelihood of people.</p>
<h5 class="fw-bold text-ktc mb-3"><i class="bi bi-people-fill me-2"></i>Motto</h5>
<p class="fw-bold fs-5">"Together for Development"</p>
</div>
<div class="mt-4 d-flex flex-wrap gap-2">
<a href="{{ route('about.wards-villages') }}" class="btn btn-ktc-primary">Wards &amp; Villages</a>
<a href="{{ route('leadership.index') }}" class="btn btn-ktc-outline">Leadership</a>
<a href="{{ route('about.location') }}" class="btn btn-ktc-outline">Location &amp; Map</a>
</div>
</div>
</div>
</div>
</section>
@endsection
