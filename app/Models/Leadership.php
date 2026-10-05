<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leadership extends Model
{
    use SoftDeletes;

    protected $table = 'leadership';

    protected $fillable = [
        'name', 'title', 'category', 'department_id', 'ward_id', 'bio',
        'photo', 'phone', 'email', 'qualifications', 'term_start', 'term_end',
        'message', 'show_message_on_homepage', 'sort_order', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'term_start'               => 'date',
            'term_end'                 => 'date',
            'is_active'                => 'boolean',
            'show_message_on_homepage' => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
