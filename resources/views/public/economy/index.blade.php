@extends('layouts.public')
@section('meta_title','Economy & Investment — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Economy</li></ol></nav><h1 class="mt-2">Economy &amp; Investment</h1></div></div>
<section class="section-pad"><div class="container">
<p class="lead col-lg-8 mb-5">Kijura Town Council has a diverse economy anchored by tea growing, agriculture, trade and markets. The area offers significant investment opportunities in agro-processing, trade and services.</p>
<div class="row g-4">
@foreach([
    ['economy.tea','Tea Growing','bi-tree','TAMTECO and Kamusanga Tea Factories anchor the tea sector. Tea growing is the primary cash crop for many households in and around Kijura.'],
    ['economy.agriculture','Agriculture','bi-basket','Maize, beans, bananas and other food crops support household food security and generate income for local farmers.'],
    ['economy.trade','Trade & Markets','bi-shop','Kijura and Kyaitamba trading centres serve as commercial hubs with retail shops, restaurants and weekly markets.'],
    ['economy.investment','Investment Opportunities','bi-graph-up','The growing population and strategic location create opportunities in agro-processing, hospitality, retail and professional services.'],
] as [$route,$title,$icon,$desc])
<div class="col-md-6">
    <a href="{{ route($route) }}" class="text-decoration-none">
        <div class="ktc-card card h-100 p-4">
            <div class="service-icon mb-3"><i class="bi {{ $icon }}"></i></div>
            <h4>{{ $title }}</h4>
            <p class="text-muted">{{ $desc }}</p>
            <span class="text-ktc small">Learn more <i class="bi bi-arrow-right ms-1"></i></span>
        </div>
    </a>
</div>
@endforeach
</div>
</div></section>
@endsection
