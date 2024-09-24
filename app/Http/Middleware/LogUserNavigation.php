<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class LogUserNavigation
{
    public function handle(Request $request, Closure $next)
    {
        // Log the navigation action
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'event_type' => 'navigation',
                'details' => 'Visited route: ' . $request->path(),
                'ip_address' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}

