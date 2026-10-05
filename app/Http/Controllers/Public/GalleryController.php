<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::active()->withCount('images')->orderBy('sort_order')->paginate(12);
        return view('public.gallery.index', compact('albums'));
    }

    public function show(GalleryAlbum $galleryAlbum)
    {
        abort_unless($galleryAlbum->is_active, 404);
        $galleryAlbum->load(['images' => fn ($q) => $q->where('is_active', true)]);
        return view('public.gallery.show', compact('galleryAlbum'));
    }
}
