<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'reference_number', 'type', 'department_id',
        'description', 'requirements', 'responsibilities', 'salary_scale',
        'duty_station', 'vacancies_count', 'application_method', 'application_email',
        'published_date', 'closing_date', 'status', 'is_active',
        'meta_title', 'meta_description', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'published_date' => 'date',
            'closing_date'   => 'date',
            'is_active'      => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attachments()
    {
        return $this->hasMany(VacancyAttachment::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')->where('closing_date', '>=', now());
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'vacancy'     => 'Job Vacancy',
            'internship'  => 'Internship',
            'training'    => 'Training',
            'scholarship' => 'Scholarship',
            default       => ucfirst($this->type),
        };
    }
}
