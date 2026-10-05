<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
    <url><loc>{{ route('about.index') }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('leadership.index') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ route('departments.index') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ route('services.index') }}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('economy.index') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ route('projects.index') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('news.index') }}</loc><changefreq>daily</changefreq><priority>0.9</priority></url>
    <url><loc>{{ route('tenders.index') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('vacancies.index') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ route('documents.index') }}</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ route('gallery.index') }}</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ route('feedback.index') }}</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ route('feedback.contact') }}</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
    @foreach(\App\Models\News::published()->latest('published_at')->limit(100)->get() as $n)
    <url><loc>{{ route('news.show',$n->slug) }}</loc><lastmod>{{ $n->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>
    @endforeach
    @foreach(\App\Models\Project::active()->get() as $p)
    <url><loc>{{ route('projects.show',$p->slug) }}</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>
    @endforeach
</urlset>
