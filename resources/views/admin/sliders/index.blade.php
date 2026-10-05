@extends('layouts.admin')
@section('title','Sliders')
@section('breadcrumb')<li class="breadcrumb-item active">Sliders</li>@endsection
@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h5><i class="bi bi-images me-2"></i>Hero Sliders</h5>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>New Slide</a>
    </div>
    <table class="table table-admin">
        <thead><tr><th>#</th><th>Image</th><th>Title</th><th>Status</th><th>Order</th><th></th></tr></thead>
        <tbody>
        @forelse($sliders as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td><img src="{{ asset('storage/'.$s->image) }}" style="height:48px;width:80px;object-fit:cover;border-radius:4px" alt="{{ $s->title }}"></td>
            <td><div class="fw-semibold">{{ $s->title }}</div><small class="text-muted">{{ $s->subtitle }}</small></td>
            <td><span class="badge bg-{{ $s->is_active?'success':'secondary' }}">{{ $s->is_active?'Active':'Inactive' }}</span></td>
            <td>{{ $s->sort_order }}</td>
            <td>
                <a href="{{ route('admin.sliders.edit',$s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.sliders.destroy',$s) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" data-confirm="Delete this slide?"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No sliders yet. <a href="{{ route('admin.sliders.create') }}">Create one</a>.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
