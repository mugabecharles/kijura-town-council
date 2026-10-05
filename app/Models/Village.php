<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ward_id', 'name', 'slug', 'local_council', 'population',
        'description', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
