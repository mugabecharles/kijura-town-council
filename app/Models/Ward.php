<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'councilor_name', 'councilor_phone',
        'area_sqkm', 'population', 'image', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'area_sqkm'  => 'decimal:2',
        ];
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function leadership()
    {
        return $this->hasMany(Leadership::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
