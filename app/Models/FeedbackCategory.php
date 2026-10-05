<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'category_id');
    }
}
