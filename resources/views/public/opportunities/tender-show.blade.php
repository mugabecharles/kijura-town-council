@extends('layouts.public')
@section('meta_title', $tender->title . ' — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('tenders.index') }}">Tenders</a></li><li class="breadcrumb-item active">{{ Str::limit($tender->title,40) }}</li></ol></nav><h1 class="mt-2">{{ $tender->title }}</h1></div></div>
<section class="section-pad"><div class="container"><div class="row g-5">
<div class="col-lg-8">
    <div class="d-flex gap-2 mb-3 flex-wrap"><span class="badge bg-{{ $tender->status_color }} fs-6">{{ ucfirst($tender->status) }}</span></div>
    <div class="prose mb-4" style="line-height:1.8">{!! nl2br(e($tender->description)) !!}</div>
    @if($tender->eligibility)<h5>Eligibility</h5><p>{{ $tender->eligibility }}</p>@endif
    @if($tender->requirements)<h5>Requirements</h5><p>{{ $tender->requirements }}</p>@endif
    @if($tender->documents->isNotEmpty())
    <div class="p-3 bg-light rounded mt-4"><h5 class="mb-3"><i class="bi bi-folder me-2"></i>Tender Documents</h5>
    @foreach($tender->documents as $doc)<a href="{{ asset('storage/'.$doc->file_path) }}" class="d-flex align-items-center mb-2 text-decoration-none" download><i class="bi bi-file-earmark me-2 text-ktc fs-5"></i><span class="text-dark">{{ $doc->name }}</span></a>@endforeach</div>
    @endif
</div>
<div class="col-lg-4">
    <div class="ktc-card card p-3">
        <h6 class="fw-bold mb-3">Tender Details</h6>
        <dl class="small mb-0">
            <dt>Reference</dt><dd class="text-muted">{{ $tender->reference_number }}</dd>
            @if($tender->department)<dt>Department</dt><dd class="text-muted">{{ $tender->department->name }}</dd>@endif
            <dt>Published</dt><dd class="text-muted">{{ $tender->published_date->format('d M Y') }}</dd>
            <dt>Closing Date</dt><dd class="{{ $tender->is_expired?'text-danger fw-bold':'text-muted' }}">{{ $tender->closing_date->format('d M Y') }}</dd>
            @if($tender->estimated_value)<dt>Estimated Value</dt><dd class="text-muted">UGX {{ number_format($tender->estimated_value) }}</dd>@endif
            @if($tender->contact_person)<dt>Contact</dt><dd class="text-muted">{{ $tender->contact_person }}<br>{{ $tender->contact_phone }}<br>{{ $tender->contact_email }}</dd>@endif
        </dl>
    </div>
</div>
</div></div></section>
@endsection
