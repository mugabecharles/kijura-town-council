@extends('layouts.public')
@section('meta_title', 'Feedback & Complaints — Kijura Town Council')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Feedback</li></ol></nav><h1 class="mt-2">Citizen Feedback &amp; Complaints</h1></div></div>

<section class="section-pad"><div class="container">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="alert alert-info mb-4"><i class="bi bi-info-circle me-2"></i>Every submission receives a unique reference number. You can track your submission using that number.</div>

@if($errors->any())
<div class="alert alert-danger mb-4">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<div class="ktc-card card p-4">
<h4 class="mb-4 fw-bold">Submit Your Feedback</h4>
<form action="{{ route('feedback.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label fw-semibold">Type *</label>
        <select name="type" class="form-select" required>
            <option value="feedback" {{ old('type')=='feedback'?'selected':'' }}>Feedback</option>
            <option value="complaint" {{ old('type')=='complaint'?'selected':'' }}>Complaint</option>
            <option value="suggestion" {{ old('type')=='suggestion'?'selected':'' }}>Suggestion</option>
            <option value="service_request" {{ old('type')=='service_request'?'selected':'' }}>Service Request</option>
        </select>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Category</label><select name="category_id" class="form-select"><option value="">— Select Category —</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Related Department</label><select name="department_id" class="form-select"><option value="">— Select Department —</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Subject *</label><input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required placeholder="Brief description of your feedback"></div>
    <div class="mb-3"><label class="form-label fw-semibold">Your Message *</label><textarea name="message" class="form-control" rows="5" required placeholder="Describe your feedback, complaint or suggestion in detail…" data-maxlength="5000">{{ old('message') }}</textarea></div>
    <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_anonymous" id="isAnon" value="1" {{ old('is_anonymous')?'checked':'' }} onchange="document.getElementById('contactFields').style.display=this.checked?'none':'block'"><label class="form-check-label" for="isAnon">Submit anonymously</label></div>
    <div id="contactFields">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label fw-semibold">Your Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Full name"></div>
            <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input type="tel" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        </div>
        <div class="mb-3"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
    </div>
    <button type="submit" class="btn btn-ktc-primary px-5"><i class="bi bi-send me-2"></i>Submit</button>
</form>
</div>

<div class="text-center mt-4">
<a href="{{ route('feedback.track') }}" class="text-ktc"><i class="bi bi-search me-1"></i>Track an existing submission</a>
</div>

</div></div>
</div></section>
@endsection
