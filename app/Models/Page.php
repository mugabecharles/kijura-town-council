<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'template', 'featured_image',
        'status', 'published_at', 'show_in_menu', 'parent_slug', 'sort_order',
        'meta_title', 'meta_description', 'og_image', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'published_at'  => 'datetime',
            'show_in_menu'  => 'boolean',
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
