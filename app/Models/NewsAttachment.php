<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsAttachment extends Model
{
    protected $fillable = ['news_id', 'name', 'file_path', 'file_type', 'file_size', 'sort_order'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
