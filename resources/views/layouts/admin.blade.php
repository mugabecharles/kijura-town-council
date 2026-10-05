<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ $siteSettings['site_name'] }} CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

{{-- SIDEBAR --}}
<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <i class="bi bi-building-fill me-2"></i>
        <span>KTC Admin</span>
    </div>

    <div class="sidebar-user">
        <div class="d-flex align-items-center">
            <div class="avatar-circle me-2">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="overflow-hidden">
                <div class="fw-semibold text-white small text-truncate">{{ auth()->user()->name }}</div>
                <div class="text-white-50 x-small text-truncate">{{ auth()->user()->getRoleNames()->first() ?? 'Staff' }}</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section-label mt-3">Content</div>
        <a href="{{ route('admin.sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Sliders
        </a>
        <a href="{{ route('admin.news.index') }}" class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> News &amp; Media
        </a>
        <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Projects
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <i class="bi bi-camera"></i> Gallery
        </a>
        <a href="{{ route('admin.documents.index') }}" class="sidebar-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
            <i class="bi bi-folder"></i> Documents
        </a>

        <div class="sidebar-section-label mt-3">Opportunities</div>
        <a href="{{ route('admin.tenders.index') }}" class="sidebar-link {{ request()->routeIs('admin.tenders.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> Tenders
        </a>
        <a href="{{ route('admin.vacancies.index') }}" class="sidebar-link {{ request()->routeIs('admin.vacancies.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> Vacancies
        </a>

        <div class="sidebar-section-label mt-3">Council</div>
        <a href="{{ route('admin.leadership.index') }}" class="sidebar-link {{ request()->routeIs('admin.leadership.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Leadership
        </a>
        <a href="{{ route('admin.departments.index') }}" class="sidebar-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i> Departments
        </a>
        <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Services
        </a>
        <a href="{{ route('admin.feedback.index') }}" class="sidebar-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Feedback
            @php $newFeedback = \App\Models\Feedback::where('status','new')->count(); @endphp
            @if($newFeedback > 0)
                <span class="badge bg-danger ms-auto">{{ $newFeedback }}</span>
            @endif
        </a>

        <div class="sidebar-section-label mt-3">System</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i> Settings
        </a>
        <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Audit Log
        </a>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> View Website
        </a>
    </nav>
</div>

{{-- MAIN AREA --}}
<div class="admin-main" id="adminMain">

    {{-- TOP BAR --}}
    <div class="admin-topbar">
        <button class="btn btn-link sidebar-toggle me-2" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="me-auto">
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    {{-- CONTENT --}}
    <div class="admin-content">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
