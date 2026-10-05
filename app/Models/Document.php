<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'category_id', 'department_id', 'description',
        'file_path', 'file_name', 'file_type', 'file_size', 'year',
        'published_date', 'downloads', 'is_public', 'is_active',
        'meta_title', 'meta_description', 'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'published_date' => 'date',
            'is_public'      => 'boolean',
            'is_active'      => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return 'Unknown';
        $kb = $this->file_size / 1024;
        if ($kb < 1024) return round($kb, 1) . ' KB';
        return round($kb / 1024, 1) . ' MB';
    }

    public function getFileIconAttribute(): string
    {
        return match (strtolower($this->file_type)) {
            'application/pdf'                                           => 'bi-file-pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'bi-file-word',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'       => 'bi-file-excel',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'bi-file-ppt',
            default => 'bi-file-earmark',
        };
    }
}
