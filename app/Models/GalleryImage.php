<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'album_id', 'image', 'thumbnail', 'caption', 'alt_text', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class);
    }
}
