@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h4 class="fw-bold mb-4">Dashboard</h4>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $statItems = [
        ['icon'=>'bi-newspaper',       'color'=>'bg-primary bg-opacity-10 text-primary',  'label'=>'News Articles',    'value'=>$stats['news'],      'url'=>route('admin.news.index'),      'border'=>'#0d6efd'],
        ['icon'=>'bi-building',        'color'=>'bg-success bg-opacity-10 text-success',  'label'=>'Projects',         'value'=>$stats['projects'],  'url'=>route('admin.projects.index'),  'border'=>'#198754'],
        ['icon'=>'bi-clipboard-check', 'color'=>'bg-warning bg-opacity-10 text-warning',  'label'=>'Open Tenders',     'value'=>$stats['tenders'],   'url'=>route('admin.tenders.index'),   'border'=>'#ffc107'],
        ['icon'=>'bi-briefcase',       'color'=>'bg-info bg-opacity-10 text-info',        'label'=>'Open Vacancies',   'value'=>$stats['vacancies'], 'url'=>route('admin.vacancies.index'), 'border'=>'#0dcaf0'],
        ['icon'=>'bi-folder',          'color'=>'bg-secondary bg-opacity-10 text-secondary','label'=>'Documents',     'value'=>$stats['documents'], 'url'=>route('admin.documents.index'), 'border'=>'#6c757d'],
        ['icon'=>'bi-chat-dots',       'color'=>'bg-danger bg-opacity-10 text-danger',    'label'=>'New Feedback',     'value'=>$stats['feedback'],  'url'=>route('admin.feedback.index'),  'border'=>'#dc3545'],
        ['icon'=>'bi-camera',          'color'=>'bg-purple bg-opacity-10',                'label'=>'Gallery Albums',   'value'=>$stats['gallery'],   'url'=>route('admin.gallery.index'),   'border'=>'#6f42c1'],
        ['icon'=>'bi-people',          'color'=>'bg-teal bg-opacity-10',                  'label'=>'Users',            'value'=>$stats['users'],     'url'=>route('admin.users.index'),     'border'=>'#20c997'],
    ];
    @endphp

    @foreach($statItems as $item)
    <div class="col-6 col-md-4 col-xl-3">
        <a href="{{ $item['url'] }}" class="text-decoration-none">
            <div class="stat-card" style="border-left-color:{{ $item['border'] }}">
                <div class="stat-icon {{ $item['color'] }}">
                    <i class="bi {{ $item['icon'] }}"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $item['value'] }}</div>
                    <div class="stat-label">{{ $item['label'] }}</div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-4">

    {{-- Recent News --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-newspaper me-2 text-primary"></i>Recent News</h5>
                <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus me-1"></i>Add</a>
            </div>
            @forelse($recentNews as $article)
            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                    <a href="{{ route('admin.news.edit', $article) }}" class="text-decoration-none text-dark fw-semibold small">{{ Str::limit($article->title, 60) }}</a>
                    <div class="text-muted x-small mt-1">
                        <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }} me-1">{{ ucfirst($article->status) }}</span>
                        {{ $article->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small">No news articles yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Feedback --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-chat-dots me-2 text-danger"></i>Recent Feedback</h5>
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            @forelse($recentFeedback as $fb)
            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                    <a href="{{ route('admin.feedback.show', $fb) }}" class="text-decoration-none text-dark fw-semibold small">{{ Str::limit($fb->subject, 55) }}</a>
                    <div class="text-muted x-small mt-1">
                        <span class="badge bg-{{ $fb->status_color }} me-1">{{ $fb->status_label }}</span>
                        {{ $fb->reference_number }} · {{ $fb->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small">No feedback submissions yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Projects --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-building me-2 text-success"></i>Recent Projects</h5>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus me-1"></i>Add</a>
            </div>
            @forelse($recentProjects as $project)
            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-decoration-none text-dark fw-semibold small">{{ Str::limit($project->title, 55) }}</a>
                    <div class="d-flex align-items-center mt-1 gap-2">
                        <div class="progress flex-grow-1" style="height:5px">
                            <div class="progress-bar bg-success" style="width:{{ $project->progress_percent }}%"></div>
                        </div>
                        <span class="x-small text-muted">{{ $project->progress_percent }}%</span>
                        <span class="badge bg-{{ $project->status_color }} x-small">{{ $project->status_label }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small">No projects yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Audit Log --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="bi bi-journal-text me-2"></i>Recent Activity</h5>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary">Full Log</a>
            </div>
            @forelse($auditLogs as $log)
            <div class="mb-2 pb-2 border-bottom x-small">
                <span class="badge bg-secondary me-1">{{ $log->action }}</span>
                {{ Str::limit($log->description, 60) }}
                <div class="text-muted">{{ $log->user?->name ?? 'System' }} · {{ $log->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <p class="text-muted small">No activity logged yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
