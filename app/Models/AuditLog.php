<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id', 'description',
        'old_values', 'new_values', 'ip_address', 'user_agent', 'url', 'method',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $description, ?Model $model = null, array $oldValues = [], array $newValues = []): void
    {
        static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => $model ? get_class($model) : null,
            'model_id'    => $model?->getKey(),
            'description' => $description,
            'old_values'  => $oldValues ?: null,
            'new_values'  => $newValues ?: null,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'url'         => request()->fullUrl(),
            'method'      => request()->method(),
            'created_at'  => now(),
        ]);
    }
}
