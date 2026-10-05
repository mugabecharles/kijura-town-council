<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $type  = $request->get('type', 'news');
        $query = News::published()
            ->with(['category', 'author'])
            ->when(in_array($type, ['news','announcement','event','press_release']), fn ($q) => $q->ofType($type))
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->when($request->search,   fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_at');

        $news       = $query->paginate(12)->withQueryString();
        $categories = NewsCategory::where('is_active', true)->withCount(['news' => fn ($q) => $q->published()])->get();

        return view('public.news.index', compact('news', 'categories', 'type'));
    }

    public function show(News $news)
    {
        abort_unless($news->status === 'published', 404);
        $news->increment('views');
        $news->load(['category', 'author', 'attachments']);

        $related = News::published()
            ->ofType($news->type)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->limit(3)->get();

        return view('public.news.show', compact('news', 'related'));
    }
}
