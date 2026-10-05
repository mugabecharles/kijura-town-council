<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'short_name', 'description', 'head_name', 'head_title',
        'phone', 'email', 'location', 'icon', 'image', 'sort_order',
        'is_active', 'show_on_website', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active'       => 'boolean',
            'show_on_website' => 'boolean',
        ];
    }

    public function leadership()
    {
        return $this->hasMany(Leadership::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
