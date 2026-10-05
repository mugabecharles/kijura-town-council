@extends('layouts.admin')
@section('title','Projects')
@section('breadcrumb')<li class="breadcrumb-item active">Projects</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="bi bi-building me-2"></i>Projects</h5>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New Project</a>
    </div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All Statuses</option>@foreach(['planned','procurement','ongoing','completed','delayed','suspended'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="department" class="form-select form-select-sm"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ request('department')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Title</th><th>Status</th><th>Progress</th><th>Dept</th><th>Budget</th><th></th></tr></thead>
        <tbody>
        @forelse($projects as $p)
        <tr>
            <td><div class="fw-semibold small">{{ Str::limit($p->title,50) }}</div><small class="text-muted">{{ $p->location }}</small></td>
            <td><span class="badge bg-{{ $p->status_color }}">{{ $p->status_label }}</span></td>
            <td><div class="d-flex align-items-center gap-1"><div class="progress flex-grow-1" style="height:5px;width:80px"><div class="progress-bar bg-success" style="width:{{ $p->progress_percent }}%"></div></div><small>{{ $p->progress_percent }}%</small></div></td>
            <td class="small text-muted">{{ $p->department?->short_name ?? $p->department?->name }}</td>
            <td class="small text-muted">{{ $p->budget ? 'UGX '.number_format($p->budget) : '—' }}</td>
            <td>
                <a href="{{ route('admin.projects.edit',$p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.projects.destroy',$p) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" data-confirm="Delete this project?"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No projects yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $projects->links() }}
</div>
@endsection
