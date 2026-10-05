@extends('layouts.admin')
@section('title', 'Feedback: '.$feedback->reference_number)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('admin.feedback.index') }}">Feedback</a></li><li class="breadcrumb-item active">{{ $feedback->reference_number }}</li>@endsection
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div><h5 class="mb-1">{{ $feedback->subject }}</h5><span class="badge bg-{{ $feedback->status_color }} me-1">{{ $feedback->status_label }}</span><span class="badge bg-info text-dark">{{ $feedback->type_label }}</span></div>
                <div class="text-muted small">{{ $feedback->reference_number }}</div>
            </div>
            <div class="bg-light rounded p-3 mb-3"><p class="mb-0">{{ $feedback->message }}</p></div>
            <dl class="row small">
                <dt class="col-sm-3">From</dt><dd class="col-sm-9">{{ $feedback->is_anonymous ? 'Anonymous' : $feedback->name }}</dd>
                @if(!$feedback->is_anonymous && $feedback->email)<dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $feedback->email }}</dd>@endif
                @if($feedback->phone)<dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $feedback->phone }}</dd>@endif
                <dt class="col-sm-3">Category</dt><dd class="col-sm-9">{{ $feedback->category?->name ?? '—' }}</dd>
                <dt class="col-sm-3">Department</dt><dd class="col-sm-9">{{ $feedback->department?->name ?? '—' }}</dd>
                <dt class="col-sm-3">Submitted</dt><dd class="col-sm-9">{{ $feedback->created_at->format('d M Y H:i') }}</dd>
            </dl>
        </div>

        {{-- Responses --}}
        <div class="admin-card mb-3">
            <div class="admin-card-header"><h6 class="mb-0">Responses</h6></div>
            @forelse($feedback->responses as $resp)
            <div class="mb-3 p-3 rounded {{ $resp->is_internal ? 'bg-warning bg-opacity-10 border border-warning' : 'bg-light' }}">
                <div class="d-flex justify-content-between mb-1">
                    <strong class="small">{{ $resp->user?->name ?? 'System' }}</strong>
                    <small class="text-muted">{{ $resp->created_at->format('d M Y H:i') }} @if($resp->is_internal)<span class="badge bg-warning text-dark ms-1">Internal</span>@endif</small>
                </div>
                <p class="mb-0 small">{{ $resp->message }}</p>
            </div>
            @empty<p class="text-muted small">No responses yet.</p>@endforelse

            <form action="{{ route('admin.feedback.responses.store',$feedback) }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-2"><textarea name="message" class="form-control" rows="3" placeholder="Add response…" required></textarea></div>
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check"><input class="form-check-input" type="checkbox" name="is_internal" id="isInternal" value="1"><label class="form-check-label small" for="isInternal">Internal note (not visible to submitter)</label></div>
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Send Response</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card">
            <h6 class="fw-bold mb-3">Update Status</h6>
            <form action="{{ route('admin.feedback.update',$feedback) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['new','assigned','under_investigation','in_progress','resolved','closed'] as $s)<option value="{{ $s }}" {{ $feedback->status==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Assign To</label><select name="assigned_to" class="form-select"><option value="">— Unassigned —</option>@foreach($staff as $u)<option value="{{ $u->id }}" {{ $feedback->assigned_to==$u->id?'selected':'' }}>{{ $u->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label class="form-label">Admin Notes</label><textarea name="admin_notes" class="form-control" rows="2">{{ $feedback->admin_notes }}</textarea></div>
                <div class="mb-3"><label class="form-label">Resolution</label><textarea name="resolution" class="form-control" rows="2">{{ $feedback->resolution }}</textarea></div>
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
