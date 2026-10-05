<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Feedback;
use App\Models\GalleryAlbum;
use App\Models\News;
use App\Models\Project;
use App\Models\Tender;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news'      => News::count(),
            'projects'  => Project::count(),
            'tenders'   => Tender::where('status', 'open')->count(),
            'vacancies' => Vacancy::where('status', 'open')->count(),
            'documents' => Document::count(),
            'feedback'  => Feedback::where('status', 'new')->count(),
            'gallery'   => GalleryAlbum::count(),
            'users'     => User::count(),
        ];

        $recentNews     = News::with('author')->latest()->limit(5)->get();
        $recentFeedback = Feedback::latest()->limit(5)->get();
        $recentProjects = Project::latest()->limit(5)->get();
        $auditLogs      = AuditLog::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentNews', 'recentFeedback', 'recentProjects', 'auditLogs'));
    }
}
