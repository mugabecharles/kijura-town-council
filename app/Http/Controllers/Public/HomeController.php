<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\News;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Tender;
use App\Models\Vacancy;

class HomeController extends Controller
{
    public function index()
    {
        $sliders  = Slider::active()->get();
        $news     = News::published()->ofType('news')->with('category')->latest('published_at')->limit(6)->get();
        $announcements = News::published()->ofType('announcement')->latest('published_at')->limit(3)->get();
        $projects = Project::active()->featured()->with(['department', 'ward'])->limit(6)->get();
        $services = Service::active()->where('show_on_homepage', true)->orderBy('sort_order')->limit(8)->get();
        $tenders  = Tender::open()->latest('published_date')->limit(3)->get();
        $vacancies = Vacancy::open()->latest('published_date')->limit(3)->get();
        $gallery  = GalleryAlbum::active()->where('show_on_homepage', true)
            ->with(['images' => fn ($q) => $q->limit(1)])->limit(8)->get();

        return view('public.home', compact(
            'sliders', 'news', 'announcements', 'projects',
            'services', 'tenders', 'vacancies', 'gallery'
        ));
    }
}
