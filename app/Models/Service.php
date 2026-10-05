<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'department_id', 'description', 'full_description',
        'requirements', 'steps', 'fee', 'duration', 'contact_person',
        'contact_phone', 'contact_email', 'location', 'hours',
        'icon', 'image', 'is_active', 'show_on_homepage', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active'        => 'boolean',
            'show_on_homepage' => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getStepsArrayAttribute(): array
    {
        if (!$this->steps) return [];
        $decoded = json_decode($this->steps, true);
        return is_array($decoded) ? $decoded : [];
    }
}
