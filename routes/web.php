<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public as Pub;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC ROUTES ─────────────────────────────────────────────────────────

Route::get('/', [Pub\HomeController::class, 'index'])->name('home');

// Search
Route::get('/search', [Pub\SearchController::class, 'index'])->name('search');

// About
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/',               [Pub\AboutController::class, 'index'])->name('index');
    Route::get('/history',        [Pub\AboutController::class, 'history'])->name('history');
    Route::get('/wards-villages', [Pub\AboutController::class, 'wardsVillages'])->name('wards-villages');
    Route::get('/location',       [Pub\AboutController::class, 'location'])->name('location');
});

// Leadership
Route::prefix('leadership')->name('leadership.')->group(function () {
    Route::get('/',         [Pub\LeadershipController::class, 'index'])->name('index');
    Route::get('/{leadership}', [Pub\LeadershipController::class, 'show'])->name('show');
});

// Departments
Route::prefix('departments')->name('departments.')->group(function () {
    Route::get('/',                [Pub\DepartmentController::class, 'index'])->name('index');
    Route::get('/{department:slug}', [Pub\DepartmentController::class, 'show'])->name('show');
});

// Services
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/',              [Pub\ServiceController::class, 'index'])->name('index');
    Route::get('/{service:slug}', [Pub\ServiceController::class, 'show'])->name('show');
});

// Economy — static pages served from views
Route::prefix('economy')->name('economy.')->group(function () {
    Route::get('/',          fn () => view('public.economy.index'))->name('index');
    Route::get('/tea',       fn () => view('public.economy.tea'))->name('tea');
    Route::get('/agriculture', fn () => view('public.economy.agriculture'))->name('agriculture');
    Route::get('/trade',     fn () => view('public.economy.trade'))->name('trade');
    Route::get('/investment', fn () => view('public.economy.investment'))->name('investment');
});

// Projects
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/',               [Pub\ProjectController::class, 'index'])->name('index');
    Route::get('/{project:slug}', [Pub\ProjectController::class, 'show'])->name('show');
});

// News & Media
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/',            [Pub\NewsController::class, 'index'])->name('index');
    Route::get('/{news:slug}', [Pub\NewsController::class, 'show'])->name('show');
});

// Opportunities — Tenders
Route::prefix('tenders')->name('tenders.')->group(function () {
    Route::get('/',              [Pub\OpportunitiesController::class, 'tenders'])->name('index');
    Route::get('/{tender:slug}', [Pub\OpportunitiesController::class, 'tenderShow'])->name('show');
});

// Opportunities — Vacancies
Route::prefix('vacancies')->name('vacancies.')->group(function () {
    Route::get('/',                [Pub\OpportunitiesController::class, 'vacancies'])->name('index');
    Route::get('/{vacancy:slug}',  [Pub\OpportunitiesController::class, 'vacancyShow'])->name('show');
});

// Documents
Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/',          [Pub\DocumentsController::class, 'index'])->name('index');
    Route::get('/{document}/download', [Pub\DocumentsController::class, 'download'])->name('download');
});

// Gallery
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/',                       [Pub\GalleryController::class, 'index'])->name('index');
    Route::get('/{galleryAlbum:slug}',    [Pub\GalleryController::class, 'show'])->name('show');
});

// Citizen Engagement / Feedback
Route::prefix('citizen')->name('feedback.')->group(function () {
    Route::get('/feedback',    [Pub\FeedbackController::class, 'index'])->name('index');
    Route::post('/feedback',   [Pub\FeedbackController::class, 'store'])->name('store');
    Route::get('/thankyou',    [Pub\FeedbackController::class, 'thankyou'])->name('thankyou');
    Route::match(['get','post'], '/track', [Pub\FeedbackController::class, 'track'])->name('track');
    Route::get('/contact',     [Pub\FeedbackController::class, 'contact'])->name('contact');
});

// Sitemap
Route::get('/sitemap.xml', function () {
    $content = view('public.sitemap')->render();
    return response($content, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

// ─── ADMIN AUTH ────────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login',  [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // ─── PROTECTED ADMIN ROUTES ────────────────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Sliders
        Route::resource('sliders', Admin\SliderController::class);
        Route::post('sliders/reorder', [Admin\SliderController::class, 'reorder'])->name('sliders.reorder');

        // News
        Route::resource('news', Admin\NewsController::class);

        // Projects
        Route::resource('projects', Admin\ProjectController::class);
        Route::post('projects/{project}/updates', [Admin\ProjectController::class, 'addUpdate'])->name('projects.updates.store');

        // Tenders
        Route::resource('tenders', Admin\TenderController::class);

        // Vacancies
        Route::resource('vacancies', Admin\VacancyController::class);

        // Documents
        Route::resource('documents', Admin\DocumentController::class);
        Route::get('documents/{document}/download', [Admin\DocumentController::class, 'download'])->name('documents.download');

        // Gallery
        Route::resource('gallery', Admin\GalleryController::class);
        Route::post('gallery/{album}/images', [Admin\GalleryController::class, 'uploadImages'])->name('gallery.images.upload');
        Route::delete('gallery/images/{image}', [Admin\GalleryController::class, 'deleteImage'])->name('gallery.images.delete');

        // Feedback
        Route::get('feedback',              [Admin\FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('feedback/{feedback}',   [Admin\FeedbackController::class, 'show'])->name('feedback.show');
        Route::put('feedback/{feedback}',   [Admin\FeedbackController::class, 'update'])->name('feedback.update');
        Route::post('feedback/{feedback}/responses', [Admin\FeedbackController::class, 'addResponse'])->name('feedback.responses.store');
        Route::delete('feedback/{feedback}', [Admin\FeedbackController::class, 'destroy'])->name('feedback.destroy');

        // Leadership
        Route::resource('leadership', Admin\LeadershipController::class);

        // Departments
        Route::resource('departments', Admin\DepartmentController::class);

        // Services
        Route::resource('services', Admin\ServiceController::class);

        // Users
        Route::resource('users', Admin\UserController::class);

        // Settings
        Route::get('settings',  [Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings',  [Admin\SettingsController::class, 'update'])->name('settings.update');

        // Audit Logs
        Route::get('audit-logs', function () {
            $logs = \App\Models\AuditLog::with('user')->latest()->paginate(30);
            return view('admin.audit-logs.index', compact('logs'));
        })->name('audit-logs.index');
    });
});
