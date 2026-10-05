<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacancyAttachment extends Model
{
    protected $fillable = ['vacancy_id', 'name', 'file_path', 'file_type', 'file_size'];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
