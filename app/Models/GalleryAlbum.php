<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryAlbum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'cover_image', 'category',
        'event_date', 'is_active', 'show_on_homepage', 'sort_order', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'event_date'       => 'date',
            'is_active'        => 'boolean',
            'show_on_homepage' => 'boolean',
        ];
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'album_id')->orderBy('sort_order');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageCountAttribute(): int
    {
        return $this->images()->count();
    }
}
