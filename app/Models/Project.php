<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'code', 'department_id', 'ward_id', 'location',
        'description', 'full_description', 'budget', 'funding_source',
        'contractor', 'contractor_contact', 'start_date', 'expected_completion',
        'actual_completion', 'progress_percent', 'status', 'featured_image',
        'latitude', 'longitude', 'map_link', 'is_featured', 'is_active',
        'meta_title', 'meta_description', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date'          => 'date',
            'expected_completion' => 'date',
            'actual_completion'   => 'date',
            'budget'              => 'decimal:2',
            'latitude'            => 'decimal:7',
            'longitude'           => 'decimal:7',
            'is_featured'         => 'boolean',
            'is_active'           => 'boolean',
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

    public function updates()
    {
        return $this->hasMany(ProjectUpdate::class)->latest('update_date');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function projectDocuments()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'planned'     => 'secondary',
            'procurement' => 'warning',
            'ongoing'     => 'primary',
            'completed'   => 'success',
            'delayed'     => 'danger',
            'suspended'   => 'dark',
            default       => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'planned'     => 'Planned',
            'procurement' => 'Procurement',
            'ongoing'     => 'Ongoing',
            'completed'   => 'Completed',
            'delayed'     => 'Delayed',
            'suspended'   => 'Suspended',
            default       => ucfirst($this->status),
        };
    }
}
