<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\News;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tender;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return view('public.search', ['results' => [], 'query' => $q, 'total' => 0]);
        }

        $like = "%{$q}%";

        $news = News::published()
            ->where(fn ($s) => $s->where('title', 'like', $like)->orWhere('excerpt', 'like', $like))
            ->limit(5)->get()->map(fn ($n) => [
                'type'  => 'News',
                'title' => $n->title,
                'url'   => route('news.show', $n->slug),
                'date'  => $n->published_at?->format('d M Y'),
                'icon'  => 'bi-newspaper',
            ]);

        $projects = Project::active()
            ->where(fn ($s) => $s->where('title', 'like', $like)->orWhere('description', 'like', $like))
            ->limit(5)->get()->map(fn ($p) => [
                'type'  => 'Project',
                'title' => $p->title,
                'url'   => route('projects.show', $p->slug),
                'date'  => $p->status_label,
                'icon'  => 'bi-building',
            ]);

        $documents = Document::where('is_active', true)->where('is_public', true)
            ->where(fn ($s) => $s->where('title', 'like', $like)->orWhere('description', 'like', $like))
            ->limit(5)->get()->map(fn ($d) => [
                'type'  => 'Document',
                'title' => $d->title,
                'url'   => route('documents.download', $d->id),
                'date'  => $d->published_date?->format('d M Y'),
                'icon'  => 'bi-file-earmark',
            ]);

        $tenders = Tender::where(fn ($s) => $s->where('title', 'like', $like)->orWhere('reference_number', 'like', $like))
            ->limit(4)->get()->map(fn ($t) => [
                'type'  => 'Tender',
                'title' => $t->title,
                'url'   => route('tenders.show', $t->slug),
                'date'  => 'Closes: ' . $t->closing_date->format('d M Y'),
                'icon'  => 'bi-clipboard-check',
            ]);

        $vacancies = Vacancy::where('title', 'like', $like)
            ->limit(4)->get()->map(fn ($v) => [
                'type'  => $v->type_label,
                'title' => $v->title,
                'url'   => route('vacancies.show', $v->slug),
                'date'  => 'Deadline: ' . $v->closing_date->format('d M Y'),
                'icon'  => 'bi-briefcase',
            ]);

        $services = Service::active()
            ->where(fn ($s) => $s->where('name', 'like', $like)->orWhere('description', 'like', $like))
            ->limit(4)->get()->map(fn ($s) => [
                'type'  => 'Service',
                'title' => $s->name,
                'url'   => route('services.show', $s->slug),
                'date'  => null,
                'icon'  => 'bi-gear',
            ]);

        $results = collect()
            ->merge($news)->merge($projects)->merge($documents)
            ->merge($tenders)->merge($vacancies)->merge($services);

        return view('public.search', ['results' => $results, 'query' => $q, 'total' => $results->count()]);
    }
}
