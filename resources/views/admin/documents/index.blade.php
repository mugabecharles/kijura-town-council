@extends('layouts.admin')
@section('title','Documents')
@section('breadcrumb')<li class="breadcrumb-item active">Documents</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h5><i class="bi bi-folder me-2"></i>Document Library</h5><a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>Upload Document</a></div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="category" class="form-select form-select-sm"><option value="">All Categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="department" class="form-select form-select-sm"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><input type="text" name="year" class="form-control form-control-sm" placeholder="Year" value="{{ request('year') }}"></div>
        <div class="col-md-2"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Title</th><th>Category</th><th>Year</th><th>Size</th><th>Downloads</th><th></th></tr></thead>
        <tbody>
        @forelse($documents as $doc)
        <tr>
            <td><i class="bi {{ $doc->file_icon }} me-1 text-ktc"></i><span class="fw-semibold small">{{ Str::limit($doc->title,55) }}</span></td>
            <td class="small text-muted">{{ $doc->category?->name }}</td>
            <td class="small text-muted">{{ $doc->year }}</td>
            <td class="small text-muted">{{ $doc->file_size_formatted }}</td>
            <td class="small">{{ $doc->downloads }}</td>
            <td>
                <a href="{{ route('admin.documents.download',$doc) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i></a>
                <a href="{{ route('admin.documents.edit',$doc) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.documents.destroy',$doc) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete?"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty<tr><td colspan="6" class="text-center text-muted py-4">No documents yet.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $documents->links() }}
</div>
@endsection
