@extends('layouts.admin')
@section('title', $album->name)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li><li class="breadcrumb-item active">{{ $album->name }}</li>@endsection
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header"><h5>Photos ({{ $album->images->count() }})</h5></div>
            <form action="{{ route('admin.gallery.images.upload',$album) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="input-group">
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <button class="btn btn-primary"><i class="bi bi-upload me-1"></i>Upload Photos</button>
                </div>
                <div class="form-text">JPG/PNG/WebP, max 5 MB each</div>
            </form>
            <div class="row g-2">
                @forelse($album->images as $img)
                <div class="col-6 col-md-4 col-lg-3" id="img-{{ $img->id }}">
                    <div class="position-relative">
                        <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid rounded" style="height:100px;width:100%;object-fit:cover" alt="{{ $img->caption }}">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-0 px-1" style="font-size:.7rem"
                            onclick="deleteImage({{ $img->id }})"><i class="bi bi-x"></i></button>
                    </div>
                    <div class="x-small text-muted mt-1">{{ $img->caption }}</div>
                </div>
                @empty
                <p class="text-muted">No photos yet. Upload some above.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <h6 class="fw-bold mb-3">{{ $album->name }}</h6>
            <p class="text-muted small">{{ $album->description }}</p>
            <dl class="small">
                <dt>Category</dt><dd class="text-muted">{{ $album->category ?: '—' }}</dd>
                <dt>Event Date</dt><dd class="text-muted">{{ $album->event_date?->format('d M Y') ?? '—' }}</dd>
                <dt>Status</dt><dd><span class="badge bg-{{ $album->is_active?'success':'secondary' }}">{{ $album->is_active?'Active':'Inactive' }}</span></dd>
            </dl>
            <a href="{{ route('admin.gallery.edit',$album) }}" class="btn btn-outline-primary btn-sm w-100">Edit Album</a>
        </div>
    </div>
</div>
@push('scripts')
<script>
function deleteImage(id) {
    if (!confirm('Delete this photo?')) return;
    fetch('{{ url("admin/gallery/images") }}/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    }).then(r => r.json()).then(d => {
        if (d.success) document.getElementById('img-' + id).remove();
    });
}
</script>
@endpush
@endsection
