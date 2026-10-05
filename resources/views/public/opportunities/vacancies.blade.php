@extends('layouts.public')
@section('meta_title','Vacancies & Opportunities — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Vacancies</li></ol></nav><h1 class="mt-2">Jobs &amp; Opportunities</h1></div></div>
<section class="section-pad"><div class="container">
<div class="d-flex gap-2 mb-4 flex-wrap">
@foreach(['vacancy'=>'Vacancies','internship'=>'Internships','training'=>'Training','scholarship'=>'Scholarships'] as $t=>$l)
<a href="{{ route('vacancies.index',['type'=>$t]) }}" class="btn btn-sm {{ request('type')===$t?'btn-ktc-primary':'btn-ktc-outline' }}">{{ $l }}</a>
@endforeach
</div>
<div class="row g-3">
@forelse($vacancies as $v)
<div class="col-12">
    <div class="opportunity-item">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <span class="badge bg-info text-dark me-2">{{ $v->type_label }}</span>
                <span class="badge bg-{{ $v->status==='open'?'success':'secondary' }}">{{ ucfirst($v->status) }}</span>
                <h5 class="mt-2 mb-1"><a href="{{ route('vacancies.show',$v->slug) }}" class="text-decoration-none text-dark">{{ $v->title }}</a></h5>
                @if($v->department)<div class="small text-muted">{{ $v->department->name }}</div>@endif
                <div class="small text-muted mt-1">{{ $v->vacancies_count }} post(s) | <span class="{{ $v->closing_date < now()?'deadline-warning':'text-muted' }}">Deadline: {{ $v->closing_date->format('d M Y') }}</span></div>
            </div>
            <a href="{{ route('vacancies.show',$v->slug) }}" class="btn btn-sm btn-ktc-outline ms-3 flex-shrink-0">Details</a>
        </div>
    </div>
</div>
@empty<div class="col-12 text-center py-5 text-muted"><i class="bi bi-briefcase" style="font-size:3rem;opacity:.2"></i><p class="mt-3">No vacancies currently open.</p></div>@endforelse
</div>
<div class="mt-4">{{ $vacancies->links() }}</div>
</div></section>
@endsection
