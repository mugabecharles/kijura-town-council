@extends('layouts.admin')
@section('title','Vacancies')
@section('breadcrumb')<li class="breadcrumb-item active">Vacancies</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h5><i class="bi bi-briefcase me-2"></i>Vacancies & Opportunities</h5><a href="{{ route('admin.vacancies.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New</a></div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="type" class="form-select form-select-sm"><option value="">All Types</option>@foreach(['vacancy','internship','training','scholarship'] as $t)<option value="{{ $t }}" {{ request('type')==$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All Statuses</option>@foreach(['open','closed','filled'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Title</th><th>Type</th><th>Closes</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($vacancies as $v)
        <tr>
            <td><div class="fw-semibold small">{{ Str::limit($v->title,55) }}</div></td>
            <td><span class="badge bg-info text-dark">{{ $v->type_label }}</span></td>
            <td class="small text-muted">{{ $v->closing_date->format('d M Y') }}</td>
            <td><span class="badge bg-{{ $v->status==='open'?'success':'secondary' }}">{{ ucfirst($v->status) }}</span></td>
            <td>
                <a href="{{ route('admin.vacancies.edit',$v) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.vacancies.destroy',$v) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete?"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty<tr><td colspan="5" class="text-center text-muted py-4">No vacancies yet.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $vacancies->links() }}
</div>
@endsection
