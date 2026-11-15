<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\AuditLog;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        AuditLog::create([
            'user_id' => null,
            'action' => 'failed_login',
            'model_type' => 'User',
            'model_id' => null,
            'new_values' => ['email' => $event->credentials['email'] ?? 'unknown'],
            'ip_address' => request()->ip(),
        ]);
    }
}