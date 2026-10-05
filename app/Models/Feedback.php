<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'feedback';

    protected $fillable = [
        'reference_number', 'type', 'category_id', 'department_id', 'subject',
        'message', 'name', 'email', 'phone', 'address', 'is_anonymous',
        'status', 'admin_notes', 'resolution', 'resolved_at',
        'assigned_to', 'assigned_at', 'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'resolved_at'  => 'datetime',
            'assigned_at'  => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responses()
    {
        return $this->hasMany(FeedbackResponse::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new'                  => 'danger',
            'assigned'             => 'warning',
            'under_investigation'  => 'info',
            'in_progress'          => 'primary',
            'resolved'             => 'success',
            'closed'               => 'secondary',
            default                => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new'                  => 'New',
            'assigned'             => 'Assigned',
            'under_investigation'  => 'Under Investigation',
            'in_progress'          => 'In Progress',
            'resolved'             => 'Resolved',
            'closed'               => 'Closed',
            default                => ucfirst($this->status),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'feedback'        => 'Feedback',
            'complaint'       => 'Complaint',
            'suggestion'      => 'Suggestion',
            'service_request' => 'Service Request',
            default           => ucfirst($this->type),
        };
    }

    public static function generateReferenceNumber(): string
    {
        $year  = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'KTC-FB-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
