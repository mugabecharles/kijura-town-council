<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')->latest()->paginate(20);
        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.album-form', ['album' => new GalleryAlbum]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category'         => 'nullable|string|max:100',
            'event_date'       => 'nullable|date',
            'is_active'        => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order'       => 'nullable|integer',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['slug']             = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active']        = $request->boolean('is_active');
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');
        $data['created_by']       = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $album = GalleryAlbum::create($data);
        AuditLog::record('create', "Created gallery album: {$album->name}", $album);

        return redirect()->route('admin.gallery.show', $album)->with('success', 'Album created. Now add photos.');
    }

    public function show(GalleryAlbum $album)
    {
        $album->load('images');
        return view('admin.gallery.show', compact('album'));
    }

    public function edit(GalleryAlbum $album)
    {
        return view('admin.gallery.album-form', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $album)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category'         => 'nullable|string|max:100',
            'event_date'       => 'nullable|date',
            'is_active'        => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order'       => 'nullable|integer',
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['is_active']        = $request->boolean('is_active');
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $album->update($data);
        AuditLog::record('update', "Updated gallery album: {$album->name}", $album);

        return redirect()->route('admin.gallery.show', $album)->with('success', 'Album updated.');
    }

    public function destroy(GalleryAlbum $album)
    {
        foreach ($album->images as $img) {
            Storage::disk('public')->delete($img->image);
            if ($img->thumbnail) Storage::disk('public')->delete($img->thumbnail);
        }
        if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
        AuditLog::record('delete', "Deleted gallery album: {$album->name}", $album);
        $album->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Album deleted.');
    }

    public function uploadImages(Request $request, GalleryAlbum $album)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $count = $album->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery/' . $album->id, 'public');
            $album->images()->create([
                'image'      => $path,
                'alt_text'   => $album->name,
                'sort_order' => ++$count,
                'is_active'  => true,
            ]);
        }

        return redirect()->route('admin.gallery.show', $album)->with('success', 'Photos uploaded successfully.');
    }

    public function deleteImage(GalleryImage $image)
    {
        Storage::disk('public')->delete($image->image);
        if ($image->thumbnail) Storage::disk('public')->delete($image->thumbnail);
        $image->delete();
        return response()->json(['success' => true]);
    }
}
