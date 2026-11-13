<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupHistory extends Model
{
    protected $fillable = [
        'filename', 'disk', 'path', 'size_bytes',
        'type', 'status', 'error_message', 'created_by',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size_bytes;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function existsOnDisk(): bool
    {
        $fullPath = storage_path('app/' . $this->path);

        return file_exists($fullPath);
    }
}