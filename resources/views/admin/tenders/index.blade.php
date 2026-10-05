@extends('layouts.admin')
@section('title','Tenders')
@section('breadcrumb')<li class="breadcrumb-item active">Tenders</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h5><i class="bi bi-clipboard-check me-2"></i>Tenders</h5><a href="{{ route('admin.tenders.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New Tender</a></div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All Statuses</option>@foreach(['open','closed','cancelled','awarded'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search title or reference…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Reference</th><th>Title</th><th>Closes</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($tenders as $t)
        <tr>
            <td class="small fw-semibold">{{ $t->reference_number }}</td>
            <td><div class="fw-semibold small">{{ Str::limit($t->title,55) }}</div></td>
            <td class="small {{ $t->is_expired && $t->status==='open' ? 'text-danger' : 'text-muted' }}">{{ $t->closing_date->format('d M Y') }}</td>
            <td><span class="badge bg-{{ $t->status_color }}">{{ ucfirst($t->status) }}</span></td>
            <td>
                <a href="{{ route('admin.tenders.edit',$t) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.tenders.destroy',$t) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete?"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty<tr><td colspan="5" class="text-center text-muted py-4">No tenders yet.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $tenders->links() }}
</div>
@endsection
