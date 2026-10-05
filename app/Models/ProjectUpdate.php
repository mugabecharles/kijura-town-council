<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    protected $fillable = [
        'project_id', 'title', 'description', 'progress_percent', 'status', 'update_date', 'created_by',
    ];

    protected function casts(): array
    {
        return ['update_date' => 'date'];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
