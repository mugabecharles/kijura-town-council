@extends('layouts.public')
@section('meta_title','Investment Opportunities — Kijura')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('economy.index') }}">Economy</a></li><li class="breadcrumb-item active">Investment</li></ol></nav><h1 class="mt-2">Investment Opportunities</h1></div></div>
<section class="section-pad"><div class="container col-lg-8">
<p class="lead">Kijura Town Council offers investment opportunities in agro-processing, hospitality, retail trade, professional services and agricultural value chains.</p>
<p>The strategic location along the Fort Portal–Mubende Highway, a growing population and proximity to Fort Portal City make Kijura an attractive location for business investment.</p>
<div class="alert alert-success mt-4"><i class="bi bi-lightbulb me-2"></i>For investment inquiries, contact the Town Council offices or email <a href="mailto:{{ \App\Models\Setting::get('"'"'site_email'"'"','"'"'info@kijuratowncouncil.go.ug'"'"') }}">{{ \App\Models\Setting::get('"'"'site_email'"'"','"'"'info@kijuratowncouncil.go.ug'"'"') }}</a>.</div>
</div></section>
@endsection