<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\News;
use App\Models\NewsAttachment;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])
            ->when($request->type,   fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest();

        $news       = $query->paginate(20)->withQueryString();
        $categories = NewsCategory::all();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.form', ['item' => new News, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                   => 'required|string|max:255',
            'type'                    => 'required|in:news,announcement,event,press_release',
            'category_id'             => 'nullable|exists:news_categories,id',
            'excerpt'                 => 'nullable|string',
            'content'                 => 'required|string',
            'featured_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'featured_image_caption'  => 'nullable|string|max:255',
            'status'                  => 'required|in:draft,review,approved,published,archived',
            'published_at'            => 'nullable|date',
            'expires_at'              => 'nullable|date',
            'is_featured'             => 'nullable|boolean',
            'tags'                    => 'nullable|string',
            'event_date'              => 'nullable|string',
            'event_location'          => 'nullable|string|max:255',
            'meta_title'              => 'nullable|string|max:255',
            'meta_description'        => 'nullable|string|max:500',
            'attachments.*'           => 'nullable|file|max:10240',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['author_id']  = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news = News::create($data);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('news/attachments', 'public');
                $news->attachments()->create([
                    'name'      => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        AuditLog::record('create', "Created news: {$news->title}", $news);

        return redirect()->route('admin.news.index')->with('success', 'Article created successfully.');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.form', ['item' => $news, 'categories' => $categories]);
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'                   => 'required|string|max:255',
            'type'                    => 'required|in:news,announcement,event,press_release',
            'category_id'             => 'nullable|exists:news_categories,id',
            'excerpt'                 => 'nullable|string',
            'content'                 => 'required|string',
            'featured_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'featured_image_caption'  => 'nullable|string|max:255',
            'status'                  => 'required|in:draft,review,approved,published,archived',
            'published_at'            => 'nullable|date',
            'expires_at'              => 'nullable|date',
            'is_featured'             => 'nullable|boolean',
            'tags'                    => 'nullable|string',
            'event_date'              => 'nullable|string',
            'event_location'          => 'nullable|string|max:255',
            'meta_title'              => 'nullable|string|max:255',
            'meta_description'        => 'nullable|string|max:500',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) Storage::disk('public')->delete($news->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        if ($data['status'] === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);
        AuditLog::record('update', "Updated news: {$news->title}", $news);

        return redirect()->route('admin.news.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->featured_image) Storage::disk('public')->delete($news->featured_image);
        foreach ($news->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }
        AuditLog::record('delete', "Deleted news: {$news->title}", $news);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Article deleted.');
    }
}
