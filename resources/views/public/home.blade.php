@extends('layouts.public')

@section('meta_title', $siteSettings['site_name'] . ' — Official Website')
@section('meta_description', 'Official website of Kijura Town Council, Burahya County, Kabarole District, Western Uganda.')

@section('content')

{{-- HERO SLIDER --}}
<div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-indicators">
        @foreach($sliders as $i => $slide)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                class="{{ $i===0?'active':'' }}" aria-label="Slide {{ $i+1 }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @forelse($sliders as $i => $slide)
        <div class="carousel-item {{ $i===0?'active':'' }}">
            <div class="hero-slide" style="background-image:url('{{ asset('storage/'.$slide->image) }}')">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content col-lg-8">
                        <h1 class="hero-title mb-3">{{ $slide->title }}</h1>
                        @if($slide->subtitle)<p class="hero-subtitle mb-4">{{ $slide->subtitle }}</p>@endif
                        @if($slide->button_text && $slide->button_url)
                        <a href="{{ $slide->button_url }}" class="btn hero-btn px-4" target="{{ $slide->button_target }}">{{ $slide->button_text }} <i class="bi bi-arrow-right ms-1"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="carousel-item active">
            <div class="hero-slide" style="background:linear-gradient(135deg,#1a6b3a,#1a1a2e)">
                <div class="container">
                    <div class="hero-content col-lg-8">
                        <h1 class="hero-title mb-3">Welcome to Kijura Town Council</h1>
                        <p class="hero-subtitle mb-4">Serving our community through equitable and quality service delivery.</p>
                        <a href="{{ route('about.index') }}" class="btn hero-btn px-4">Explore Kijura <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
</div>

{{-- QUICK ACCESS --}}
<section class="quick-access">
    <div class="container">
        <div class="row g-3 justify-content-center">
            @foreach([
                ['bi-gear','Services',route('services.index')],
                ['bi-building','Projects',route('projects.index')],
                ['bi-clipboard-check','Tenders',route('tenders.index')],
                ['bi-briefcase','Vacancies',route('vacancies.index')],
                ['bi-folder','Documents',route('documents.index')],
                ['bi-cash-coin','Local Revenue',route('services.index')],
                ['bi-chat-dots','Feedback',route('feedback.index')],
                ['bi-geo-alt','Contact',route('feedback.contact')],
            ] as [$icon,$label,$url])
            <div class="col-6 col-sm-3 col-lg-auto flex-lg-fill">
                <a href="{{ $url }}" class="quick-card"><i class="bi {{ $icon }}"></i><span>{{ $label }}</span></a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section class="section-pad bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="card-tag mb-3 d-inline-block">About Kijura</span>
                <h2 class="mb-3">Kijura Town Council</h2>
                <p class="text-muted">Kijura Town Council is located in Burahya County, Kabarole District, Western Uganda, approximately 30 km north-east of Fort Portal City along the Fort Portal–Mubende Highway.</p>
                <p class="text-muted">Established on 1 July 2010 and carved out of Hakibale Sub-County, Kijura Town Council was created under the Local Government Act to bring services nearer to the people. The council comprises four wards: <strong>Kahuna, Kijura, Kaisagara and Kyererezi</strong>.</p>
                <p class="text-muted mb-4">The council is home to tea-growing communities, TAMTECO and Kamusanga Tea Factories, and a vibrant trading centre supporting thousands of residents.</p>
                <a href="{{ route('about.index') }}" class="btn btn-ktc-primary">Learn More <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3 text-center">
                    @foreach([['4','Wards'],['2010','Established'],['1,513m','Elevation'],['30km','From Fort Portal']] as [$val,$lbl])
                    <div class="col-6"><div class="bg-light rounded p-3"><div class="display-6 text-ktc fw-bold">{{ $val }}</div><div class="text-muted small">{{ $lbl }}</div></div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- VISION / MISSION / MOTTO --}}
<section class="visions-section">
    <div class="container">
        <div class="section-header mb-4"><h2 class="text-white">Our Vision, Mission &amp; Motto</h2></div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="vision-card"><div class="vision-icon"><i class="bi bi-eye"></i></div><div class="vision-label">Vision</div><h5 class="text-white">{{ \App\Models\Setting::get('homepage_vision','A well planned, economically vibrant and healthy Kijura Town Council.') }}</h5></div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="vision-card"><div class="vision-icon"><i class="bi bi-bullseye"></i></div><div class="vision-label">Mission</div><h5 class="text-white">{{ \App\Models\Setting::get('homepage_mission','To provide quality services equitably and improve livelihood of people.') }}</h5></div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="vision-card"><div class="vision-icon"><i class="bi bi-people-fill"></i></div><div class="vision-label">Motto</div><h5 class="text-white">"{{ \App\Models\Setting::get('homepage_motto','Together for Development') }}"</h5></div>
            </div>
        </div>
    </div>
</section>

{{-- COUNCIL FACTS --}}
<section class="facts-section">
    <div class="container">
        <div class="row g-4 text-center">
            @foreach([['bi-calendar-check','2010','Established'],['bi-map','4','Wards'],['bi-mountain','1,513','Metres Elevation'],['bi-geo-alt','30km','From Fort Portal']] as [$icon,$num,$lbl])
            <div class="col-6 col-md-3"><i class="bi {{ $icon }} text-gold fs-2 mb-2 d-block"></i><div class="fact-number">{{ $num }}</div><div class="fact-label">{{ $lbl }}</div></div>
            @endforeach
        </div>
    </div>
</section>

{{-- ECONOMY --}}
<section class="section-pad bg-light">
    <div class="container">
        <div class="section-header"><h2>Economy &amp; Investment</h2><p>Kijura is home to key economic activities including tea, agriculture and trade</p></div>
        <div class="row g-3">
            @foreach([
                ['economy.tea','Tea Growing','TAMTECO &amp; Kamusanga Factories','bi-tree','#1a6b3a','#2d8a4e'],
                ['economy.agriculture','Agriculture','Maize, Beans, Bananas &amp; more','bi-basket','#65a30d','#84cc16'],
                ['economy.trade','Trade &amp; Markets','Kijura &amp; Kyaitamba Markets','bi-shop','#d97706','#f59e0b'],
                ['economy.investment','Investment','Opportunities in Kijura','bi-graph-up','#0891b2','#0ea5e9'],
            ] as [$route,$title,$sub,$icon,$c1,$c2])
            <div class="col-md-6 col-lg-3">
                <a href="{{ route($route) }}" class="text-decoration-none">
                    <div class="economy-card" style="border-radius:10px;overflow:hidden">
                        <div style="height:280px;background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});display:flex;align-items:center;justify-content:center"><i class="bi {{ $icon }} text-white" style="font-size:5rem;opacity:.35"></i></div>
                        <div class="economy-card-overlay" style="border-radius:10px"><div><h4>{{ $title }}</h4><small class="text-white-50">{!! $sub !!}</small></div></div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SERVICES --}}
@if($services->isNotEmpty())
<section class="section-pad bg-white">
    <div class="container">
        <div class="section-header"><h2>Our Services</h2><p>Key services provided by Kijura Town Council to residents and businesses</p></div>
        <div class="row g-3">
            @foreach($services as $service)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('services.show',$service->slug) }}" class="text-decoration-none">
                    <div class="service-card"><div class="service-icon"><i class="bi {{ $service->icon ?: 'bi-gear' }}"></i></div><h5>{{ $service->name }}</h5><p class="text-muted small mb-0">{{ Str::limit($service->description,80) }}</p></div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4"><a href="{{ route('services.index') }}" class="btn btn-ktc-outline">View All Services <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>
@endif

{{-- PROJECTS --}}
@if($projects->isNotEmpty())
<section class="section-pad bg-light">
    <div class="container">
        <div class="section-header"><h2>Development Projects</h2><p>Key infrastructure and development initiatives</p></div>
        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-md-6 col-lg-4">
                <div class="ktc-card card">
                    @if($project->featured_image)
                    <img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top" alt="{{ $project->title }}" loading="lazy">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px"><i class="bi bi-building text-muted" style="font-size:3rem"></i></div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-{{ $project->status_color }} mb-2">{{ $project->status_label }}</span>
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="text-muted small">{{ Str::limit($project->description,100) }}</p>
                        <div class="project-status-bar mb-2"><div class="project-status-fill" style="width:{{ $project->progress_percent }}%"></div></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $project->progress_percent }}% complete</small>
                            <a href="{{ route('projects.show',$project->slug) }}" class="btn btn-sm btn-ktc-primary">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4"><a href="{{ route('projects.index') }}" class="btn btn-ktc-outline">View All Projects <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>
@endif

{{-- NEWS & ANNOUNCEMENTS --}}
<section class="section-pad bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <h3 class="mb-4 fw-bold border-bottom pb-2">Latest News</h3>
                @if($news->isEmpty())
                    <p class="text-muted">No news published yet.</p>
                @else
                <div class="row g-4">
                    @foreach($news->take(4) as $article)
                    <div class="col-md-6">
                        <div class="ktc-card card">
                            @if($article->featured_image)
                            <img src="{{ asset('storage/'.$article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" loading="lazy" style="height:180px;object-fit:cover">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px"><i class="bi bi-newspaper text-muted" style="font-size:2.5rem"></i></div>
                            @endif
                            <div class="card-body">
                                @if($article->category)<span class="card-tag" style="background:{{ $article->category->color }}">{{ $article->category->name }}</span>@endif
                                <h6 class="mt-1"><a href="{{ route('news.show',$article->slug) }}" class="text-decoration-none text-dark stretched-link">{{ $article->title }}</a></h6>
                                <div class="card-date"><i class="bi bi-calendar3 me-1"></i>{{ $article->published_at?->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4"><a href="{{ route('news.index') }}" class="btn btn-ktc-outline">All News <i class="bi bi-arrow-right ms-1"></i></a></div>
                @endif
            </div>
            <div class="col-lg-4">
                @if($announcements->isNotEmpty())
                <h3 class="mb-4 fw-bold border-bottom pb-2">Announcements</h3>
                @foreach($announcements as $ann)
                <div class="mb-3 pb-3 border-bottom">
                    <a href="{{ route('news.show',$ann->slug) }}" class="fw-semibold text-decoration-none text-dark small">{{ $ann->title }}</a>
                    <div class="text-muted" style="font-size:.75rem">{{ $ann->published_at?->format('d M Y') }}</div>
                </div>
                @endforeach
                <a href="{{ route('news.index',['type'=>'announcement']) }}" class="small text-ktc">View all →</a>
                @endif

                @if($tenders->isNotEmpty())
                <h3 class="mb-3 mt-4 fw-bold border-bottom pb-2">Open Tenders</h3>
                @foreach($tenders as $tender)
                <div class="mb-3 pb-3 border-bottom">
                    <a href="{{ route('tenders.show',$tender->slug) }}" class="fw-semibold text-decoration-none text-dark small">{{ $tender->title }}</a>
                    <div class="text-muted" style="font-size:.75rem">Ref: {{ $tender->reference_number }} | Closes: {{ $tender->closing_date->format('d M Y') }}</div>
                </div>
                @endforeach
                <a href="{{ route('tenders.index') }}" class="small text-ktc">View all →</a>
                @endif

                @if($vacancies->isNotEmpty())
                <h3 class="mb-3 mt-4 fw-bold border-bottom pb-2">Vacancies</h3>
                @foreach($vacancies as $vacancy)
                <div class="mb-3 pb-3 border-bottom">
                    <a href="{{ route('vacancies.show',$vacancy->slug) }}" class="fw-semibold text-decoration-none text-dark small">{{ $vacancy->title }}</a>
                    <div class="text-muted" style="font-size:.75rem">Closes: {{ $vacancy->closing_date->format('d M Y') }}</div>
                </div>
                @endforeach
                <a href="{{ route('vacancies.index') }}" class="small text-ktc">View all →</a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
@if($gallery->isNotEmpty())
<section class="section-pad bg-light">
    <div class="container">
        <div class="section-header"><h2>Photo Gallery</h2><p>Images from Kijura Town Council activities and infrastructure</p></div>
        <div class="row g-3">
            @foreach($gallery as $album)
            @if($album->images->first())
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('gallery.show',$album->slug) }}" class="text-decoration-none">
                    <div class="gallery-thumb">
                        <img src="{{ asset('storage/'.$album->images->first()->image) }}" alt="{{ $album->name }}" loading="lazy">
                    </div>
                    <p class="mt-1 mb-0 small fw-semibold text-dark">{{ $album->name }}</p>
                </a>
            </div>
            @endif
            @endforeach
        </div>
        <div class="text-center mt-4"><a href="{{ route('gallery.index') }}" class="btn btn-ktc-outline">View All Photos <i class="bi bi-arrow-right ms-1"></i></a></div>
    </div>
</section>
@endif

{{-- FEEDBACK CTA --}}
<section class="feedback-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h2 class="mb-2">Share Your Feedback</h2>
                <p class="text-muted mb-4">We value your input. Send us feedback, report a complaint, or make a suggestion. Every submission receives a unique reference number and is reviewed by council staff.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('feedback.index') }}" class="btn btn-ktc-primary"><i class="bi bi-chat-dots me-2"></i>Submit Feedback</a>
                    <a href="{{ route('feedback.track') }}" class="btn btn-ktc-outline"><i class="bi bi-search me-2"></i>Track Submission</a>
                </div>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0 text-center">
                <i class="bi bi-chat-square-text text-ktc" style="font-size:7rem;opacity:.15"></i>
            </div>
        </div>
    </div>
</section>

{{-- CONTACT / LOCATION --}}
<section class="section-pad bg-white">
    <div class="container">
        <div class="section-header"><h2>Our Location</h2><p>Find us on the Fort Portal–Mubende Highway, Kabarole District</p></div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-geo-alt-fill text-ktc me-2"></i><strong>Address:</strong><br><span class="text-muted ms-4">Kijura Town Council, Burahya County, Kabarole District, Western Uganda</span></li>
                    <li class="mb-3"><i class="bi bi-telephone-fill text-ktc me-2"></i><strong>Phone:</strong><br><span class="text-muted ms-4">{{ $siteSettings['site_phone'] ?: '+256 XXX XXX XXX' }}</span></li>
                    <li class="mb-3"><i class="bi bi-envelope-fill text-ktc me-2"></i><strong>Email:</strong><br><span class="text-muted ms-4">{{ $siteSettings['site_email'] }}</span></li>
                    <li class="mb-3"><i class="bi bi-clock-fill text-ktc me-2"></i><strong>Office Hours:</strong><br><span class="text-muted ms-4">Monday – Friday: 8:00 AM – 5:00 PM</span></li>
                </ul>
                <a href="{{ route('feedback.contact') }}" class="btn btn-ktc-primary">Contact Us <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="col-lg-7">
                <div class="bg-light rounded" style="height:350px;display:flex;align-items:center;justify-content:center">
                    <div class="text-center text-muted">
                        <i class="bi bi-map" style="font-size:4rem;opacity:.3"></i>
                        <p class="mt-2">Map: Coordinates 0°49'01"N 30°25'03"E<br>
                        <small>Replace with an embedded map via CMS Settings → Contact</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lightbox Modal --}}
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-label="Photo">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="lightboxImg" src="" class="img-fluid" alt="Gallery image">
                <p id="lightboxCaption" class="text-white mt-2 small"></p>
            </div>
        </div>
    </div>
</div>

{{-- Back to top --}}
<button id="backToTop" class="btn btn-ktc-primary rounded-circle" style="position:fixed;bottom:1.5rem;right:1.5rem;display:none;z-index:999;width:44px;height:44px;padding:0" aria-label="Back to top">
    <i class="bi bi-chevron-up"></i>
</button>

@endsection
