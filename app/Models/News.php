<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title', 'slug', 'type', 'category_id', 'excerpt', 'content',
        'featured_image', 'featured_image_caption', 'author_id', 'status',
        'published_at', 'expires_at', 'is_featured', 'allow_comments', 'views',
        'tags', 'event_date', 'event_location', 'meta_title', 'meta_description',
        'og_image', 'reviewed_by', 'reviewed_at', 'approved_by', 'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at'  => 'datetime',
            'expires_at'    => 'datetime',
            'reviewed_at'   => 'datetime',
            'approved_at'   => 'datetime',
            'is_featured'   => 'boolean',
            'allow_comments' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function attachments()
    {
        return $this->hasMany(NewsAttachment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? array_filter(array_map('trim', explode(',', $this->tags))) : [];
    }
}
