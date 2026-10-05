@extends('layouts.admin')
@section('title','Gallery')
@section('breadcrumb')<li class="breadcrumb-item active">Gallery</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h5><i class="bi bi-camera me-2"></i>Photo Gallery Albums</h5><a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New Album</a></div>
    <div class="row g-3 mt-1">
        @forelse($albums as $album)
        <div class="col-md-4 col-lg-3">
            <div class="admin-card p-2">
                @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}" class="img-fluid rounded mb-2" style="height:140px;width:100%;object-fit:cover" alt="{{ $album->name }}">
                @else
                <div class="bg-light rounded mb-2 d-flex align-items-center justify-content-center" style="height:140px"><i class="bi bi-images text-muted" style="font-size:2.5rem"></i></div>
                @endif
                <div class="fw-semibold small">{{ $album->name }}</div>
                <div class="text-muted x-small">{{ $album->images_count }} photos</div>
                <div class="d-flex gap-1 mt-2">
                    <a href="{{ route('admin.gallery.show',$album) }}" class="btn btn-sm btn-outline-secondary flex-fill">Photos</a>
                    <a href="{{ route('admin.gallery.edit',$album) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.gallery.destroy',$album) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete album and all photos?"><i class="bi bi-trash"></i></button></form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">No albums yet. <a href="{{ route('admin.gallery.create') }}">Create one</a>.</div>
        @endforelse
    </div>
    <div class="mt-3">{{ $albums->links() }}</div>
</div>
@endsection
