<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('meta_title', $siteSettings['site_name'] . ' — Official Website')</title>
    <meta name="description" content="@yield('meta_description', 'Official website of Kijura Town Council, Burahya County, Kabarole District, Western Uganda.')">
    <meta name="keywords" content="Kijura Town Council, Kabarole District, Uganda local government, Burahya County">
    <meta name="author" content="Kijura Town Council">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('meta_title', $siteSettings['site_name'])">
    <meta property="og:description" content="@yield('meta_description', '')">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="website">
    <meta property="og:image"       content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

{{-- TOP BAR --}}
<div class="topbar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center py-1">
            <div class="col-md-6 text-white small">
                <i class="bi bi-telephone me-1"></i> {{ $siteSettings['site_phone'] ?: '+256 XXX XXX XXX' }}
                &nbsp;&nbsp;
                <i class="bi bi-envelope me-1"></i> {{ $siteSettings['site_email'] }}
            </div>
            <div class="col-md-6 text-end">
                @if($siteSettings['facebook_url'])
                <a href="{{ $siteSettings['facebook_url'] }}" class="topbar-social" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                @endif
                @if($siteSettings['twitter_url'])
                <a href="{{ $siteSettings['twitter_url'] }}" class="topbar-social" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if($siteSettings['youtube_url'])
                <a href="{{ $siteSettings['youtube_url'] }}" class="topbar-social" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
                @endif
                <a href="{{ route('admin.login') }}" class="topbar-link ms-3"><i class="bi bi-lock me-1"></i>Staff Login</a>
            </div>
        </div>
    </div>
</div>

{{-- MAIN HEADER --}}
<header class="site-header">
    <div class="container">
        <div class="row align-items-center py-3">
            <div class="col-auto">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    @if($siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] }}" class="site-logo me-3">
                    @else
                        <div class="logo-placeholder me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-building-fill text-white fs-3"></i>
                        </div>
                    @endif
                    <div>
                        <div class="site-name">{{ $siteSettings['site_name'] }}</div>
                        <div class="site-district">Burahya County, Kabarole District, Uganda</div>
                    </div>
                </a>
            </div>
            <div class="col text-end d-none d-lg-block">
                <form action="{{ route('search') }}" method="GET" class="d-inline-flex">
                    <div class="input-group" style="width:300px">
                        <input type="search" name="q" class="form-control form-control-sm" placeholder="Search…"
                               value="{{ request('q') }}" aria-label="Search">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- NAVIGATION --}}
<nav class="navbar navbar-expand-lg main-navbar" aria-label="Main navigation">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle{{ request()->routeIs('about.*') ? ' active' : '' }}" href="#" data-bs-toggle="dropdown">About Kijura</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('about.index') }}">Council Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('about.history') }}">History &amp; Background</a></li>
                        <li><a class="dropdown-item" href="{{ route('about.wards-villages') }}">Wards &amp; Villages</a></li>
                        <li><a class="dropdown-item" href="{{ route('about.location') }}">Location &amp; Map</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('leadership.*') ? ' active' : '' }}" href="{{ route('leadership.index') }}">Leadership</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('departments.*') ? ' active' : '' }}" href="{{ route('departments.index') }}">Departments</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('services.*') ? ' active' : '' }}" href="{{ route('services.index') }}">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('economy.*') ? ' active' : '' }}" href="{{ route('economy.index') }}">Economy</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('projects.*') ? ' active' : '' }}" href="{{ route('projects.index') }}">Projects</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle{{ request()->routeIs('news.*') ? ' active' : '' }}" href="#" data-bs-toggle="dropdown">News &amp; Media</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('news.index') }}">News</a></li>
                        <li><a class="dropdown-item" href="{{ route('news.index', ['type' => 'announcement']) }}">Announcements</a></li>
                        <li><a class="dropdown-item" href="{{ route('news.index', ['type' => 'event']) }}">Events</a></li>
                        <li><a class="dropdown-item" href="{{ route('news.index', ['type' => 'press_release']) }}">Press Releases</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('gallery.index') }}">Photo Gallery</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle{{ request()->routeIs('tenders.*') || request()->routeIs('vacancies.*') ? ' active' : '' }}" href="#" data-bs-toggle="dropdown">Opportunities</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('tenders.index') }}">Tenders &amp; Procurement</a></li>
                        <li><a class="dropdown-item" href="{{ route('vacancies.index') }}">Jobs &amp; Vacancies</a></li>
                        <li><a class="dropdown-item" href="{{ route('vacancies.index', ['type' => 'internship']) }}">Internships</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('documents.*') ? ' active' : '' }}" href="{{ route('documents.index') }}">Documents</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle{{ request()->routeIs('feedback.*') ? ' active' : '' }}" href="#" data-bs-toggle="dropdown">Citizen</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('feedback.index') }}">Feedback &amp; Complaints</a></li>
                        <li><a class="dropdown-item" href="{{ route('feedback.track') }}">Track My Submission</a></li>
                        <li><a class="dropdown-item" href="{{ route('feedback.contact') }}">Contact Us</a></li>
                    </ul>
                </li>

            </ul>

            {{-- Mobile search --}}
            <form action="{{ route('search') }}" method="GET" class="d-lg-none mt-2">
                <div class="input-group">
                    <input type="search" name="q" class="form-control form-control-sm" placeholder="Search…" value="{{ request('q') }}" aria-label="Search">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</nav>

{{-- PAGE CONTENT --}}
<main id="main-content">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="site-footer mt-5">
    <div class="container">
        <div class="row g-4 py-5">

            {{-- Column 1 — About --}}
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="footer-logo-placeholder me-2">
                        <i class="bi bi-building-fill text-white"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-white">{{ $siteSettings['site_name'] }}</div>
                        <div class="text-white-50 small">Burahya County, Kabarole District</div>
                    </div>
                </div>
                <p class="text-white-50 small">{{ $siteSettings['site_tagline'] }}</p>
                <p class="text-white-50 small">
                    <i class="bi bi-geo-alt me-1"></i> {{ $siteSettings['site_address'] }}<br>
                    <i class="bi bi-telephone me-1"></i> {{ $siteSettings['site_phone'] ?: '+256 XXX XXX XXX' }}<br>
                    <i class="bi bi-envelope me-1"></i> {{ $siteSettings['site_email'] }}
                </p>
                <div class="mt-3">
                    @if($siteSettings['facebook_url'])
                    <a href="{{ $siteSettings['facebook_url'] }}" class="footer-social me-2" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook fs-5"></i></a>
                    @endif
                    @if($siteSettings['twitter_url'])
                    <a href="{{ $siteSettings['twitter_url'] }}" class="footer-social me-2" target="_blank" rel="noopener" aria-label="Twitter"><i class="bi bi-twitter-x fs-5"></i></a>
                    @endif
                    @if($siteSettings['youtube_url'])
                    <a href="{{ $siteSettings['youtube_url'] }}" class="footer-social me-2" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube fs-5"></i></a>
                    @endif
                </div>
            </div>

            {{-- Column 2 — Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('about.index') }}">About Council</a></li>
                    <li><a href="{{ route('leadership.index') }}">Leadership</a></li>
                    <li><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li><a href="{{ route('services.index') }}">Services</a></li>
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('news.index') }}">News</a></li>
                    <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                </ul>
            </div>

            {{-- Column 3 — Opportunities --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3">Opportunities</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('tenders.index') }}">Tenders</a></li>
                    <li><a href="{{ route('vacancies.index') }}">Vacancies</a></li>
                    <li><a href="{{ route('vacancies.index', ['type' => 'internship']) }}">Internships</a></li>
                    <li><a href="{{ route('documents.index') }}">Documents</a></li>
                    <li><a href="{{ route('economy.index') }}">Economy</a></li>
                </ul>
            </div>

            {{-- Column 4 — Citizen --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white mb-3">Citizen Engagement</h6>
                <ul class="list-unstyled footer-links mb-3">
                    <li><a href="{{ route('feedback.index') }}">Submit Feedback / Complaint</a></li>
                    <li><a href="{{ route('feedback.track') }}">Track My Submission</a></li>
                    <li><a href="{{ route('feedback.contact') }}">Contact Us</a></li>
                </ul>
                <a href="{{ route('feedback.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-chat-dots me-1"></i> Give Feedback
                </a>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-md-6 text-white-50 small text-center text-md-start">
                    &copy; {{ date('Y') }} {{ $siteSettings['site_name'] }}. All rights reserved.
                </div>
                <div class="col-md-6 text-white-50 small text-center text-md-end">
                    <a href="{{ route('sitemap') }}" class="text-white-50 text-decoration-none">Sitemap</a>
                    &nbsp;|&nbsp; Official Website of Kijura Town Council
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
