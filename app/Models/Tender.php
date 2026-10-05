<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'reference_number', 'department_id', 'description',
        'eligibility', 'requirements', 'estimated_value', 'currency',
        'contact_person', 'contact_phone', 'contact_email',
        'published_date', 'closing_date', 'status',
        'awarded_to', 'award_date', 'is_active',
        'meta_title', 'meta_description', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'published_date'  => 'date',
            'closing_date'    => 'date',
            'award_date'      => 'date',
            'estimated_value' => 'decimal:2',
            'is_active'       => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(TenderDocument::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')->where('closing_date', '>=', now());
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'open'      => 'success',
            'closed'    => 'secondary',
            'cancelled' => 'danger',
            'awarded'   => 'primary',
            default     => 'secondary',
        };
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->closing_date < now()->toDateString();
    }
}
