@extends('layouts.admin')
@section('title','Feedback')
@section('breadcrumb')<li class="breadcrumb-item active">Feedback</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header"><h5><i class="bi bi-chat-dots me-2"></i>Citizen Feedback & Complaints</h5></div>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><select name="status" class="form-select form-select-sm"><option value="">All Statuses</option>@foreach(['new','assigned','under_investigation','in_progress','resolved','closed'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
        <div class="col-md-3"><select name="type" class="form-select form-select-sm"><option value="">All Types</option>@foreach(['feedback','complaint','suggestion','service_request'] as $t)<option value="{{ $t }}" {{ request('type')==$t?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>@endforeach</select></div>
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Reference or subject…" value="{{ request('search') }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-secondary">Filter</button></div>
    </form>
    <table class="table table-admin">
        <thead><tr><th>Reference</th><th>Subject</th><th>Type</th><th>From</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($feedback as $fb)
        <tr>
            <td class="fw-semibold small">{{ $fb->reference_number }}</td>
            <td class="small">{{ Str::limit($fb->subject,45) }}</td>
            <td><span class="badge bg-info text-dark">{{ $fb->type_label }}</span></td>
            <td class="small text-muted">{{ $fb->is_anonymous ? 'Anonymous' : $fb->name }}</td>
            <td><span class="badge bg-{{ $fb->status_color }}">{{ $fb->status_label }}</span></td>
            <td class="small text-muted">{{ $fb->created_at->format('d M Y') }}</td>
            <td><a href="{{ route('admin.feedback.show',$fb) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty<tr><td colspan="7" class="text-center text-muted py-4">No feedback submissions yet.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $feedback->links() }}
</div>
@endsection
