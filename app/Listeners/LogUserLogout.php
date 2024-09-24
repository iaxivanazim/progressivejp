<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class LogUserLogout
{
    public function handle(Logout $event)
{
    // Get the last login event for this user
    $loginLog = AuditLog::where('user_id', $event->user->id)
                        ->where('event_type', 'login')
                        ->latest()->first();

    if ($loginLog) {
        // Ensure consistent timezone for both login and logout times
        $loginTime = $loginLog->created_at->setTimezone('Asia/Kolkata');
        $logoutTime = now()->setTimezone('Asia/Kolkata');

        // Calculate the session length in minutes
        $sessionLength = $logoutTime->diffInMinutes($loginTime);

        // Log the session length
        AuditLog::create([
            'user_id' => $event->user->id,
            'event_type' => 'logout',
            'details' => 'User logged out. Session length: ' . $sessionLength . ' minutes',
            'ip_address' => request()->ip(),
        ]);
    }
}
}

