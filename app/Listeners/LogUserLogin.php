<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class LogUserLogin
{
    public function handle(Login $event)
    {
        AuditLog::create([
            'user_id' => $event->user->id,
            'event_type' => 'login',
            'details' => 'User logged in at ' . now()->setTimezone('Asia/Kolkata'),
            'ip_address' => Request::ip(),
        ]);
    }
}

