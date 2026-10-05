@extends('layouts.admin')
@section('title','News & Media')
@section('breadcrumb')<li class="breadcrumb-item active">News & Media</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="bi bi-newspaper me-2"></i>News & Media</h5>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New Article</a>
    </div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="type" class="form-select form-select-sm"><option value="">All Types</option><option value="news" {{ request('type')=='news'?'selected':'' }}>News</option><option value="announcement" {{ request('type')=='announcement'?'selected':'' }}>Announcement</option><option value="event" {{ request('type')=='event'?'selected':'' }}>Event</option><option value="press_release" {{ request('type')=='press_release'?'selected':'' }}>Press Release</option></select></div>
        <div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All Statuses</option><option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option><option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option><option value="archived" {{ request('status')=='archived'?'selected':'' }}>Archived</option></select></div>
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search title…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Author</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($news as $n)
        <tr>
            <td><div class="fw-semibold small">{{ Str::limit($n->title,60) }}</div>@if($n->is_featured)<span class="badge bg-warning text-dark x-small">Featured</span>@endif</td>
            <td><span class="badge bg-info text-dark">{{ ucfirst($n->type) }}</span></td>
            <td><span class="badge bg-{{ $n->status==='published'?'success':($n->status==='draft'?'secondary':'warning') }}">{{ ucfirst($n->status) }}</span></td>
            <td class="small text-muted">{{ $n->author?->name }}</td>
            <td class="small text-muted">{{ $n->published_at?->format('d M Y') ?? $n->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.news.edit',$n) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.news.destroy',$n) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete this article?"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No articles yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $news->links() }}
</div>
@endsection
