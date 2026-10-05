@extends('layouts.public')
@section('meta_title', $leadership->name . ' — Leadership')
@section('content')
<div class="page-hero"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('leadership.index') }}">Leadership</a></li><li class="breadcrumb-item active">{{ $leadership->name }}</li></ol></nav><h1 class="mt-2">{{ $leadership->name }}</h1></div></div>
<section class="section-pad"><div class="container"><div class="row g-5 justify-content-center">
<div class="col-lg-3 text-center">
    @if($leadership->photo)<img src="{{ asset('storage/'.$leadership->photo) }}" class="leader-photo" alt="{{ $leadership->name }}" style="width:160px;height:160px">@else<div class="leader-photo-placeholder mx-auto" style="width:160px;height:160px"><i class="bi bi-person-fill" style="font-size:4rem"></i></div>@endif
    <h4 class="mt-3">{{ $leadership->name }}</h4>
    <div class="text-muted">{{ $leadership->title }}</div>
    @if($leadership->phone)<div class="mt-2 small"><i class="bi bi-telephone me-1"></i>{{ $leadership->phone }}</div>@endif
    @if($leadership->email)<div class="small"><i class="bi bi-envelope me-1"></i><a href="mailto:{{ $leadership->email }}">{{ $leadership->email }}</a></div>@endif
</div>
<div class="col-lg-7">
    @if($leadership->bio)<p>{{ $leadership->bio }}</p>@endif
    @if($leadership->message && $leadership->show_message_on_homepage)
    <blockquote class="blockquote bg-light p-4 rounded mt-4"><p class="mb-0 fst-italic">{{ $leadership->message }}</p><footer class="blockquote-footer mt-2">{{ $leadership->name }}</footer></blockquote>
    @endif
    <a href="{{ route('leadership.index') }}" class="btn btn-ktc-outline mt-3">← Back to Leadership</a>
</div>
</div></div></section>
@endsection
