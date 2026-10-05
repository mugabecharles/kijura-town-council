<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderDocument extends Model
{
    protected $fillable = ['tender_id', 'name', 'file_path', 'file_type', 'file_size', 'is_free'];

    protected function casts(): array
    {
        return ['is_free' => 'boolean'];
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
