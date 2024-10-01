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
        // Log the navigation action if the user is authenticated
        if (Auth::check()) {
            $currentRoute = $request->path();
            $previousRoute = session('previous_route'); // Retrieve the last route from session

            // Only log if the current route is different from the previous one
            if ($currentRoute !== $previousRoute) {
                AuditLog::create([
                    'user_id' => Auth::id(),
                    'event_type' => 'navigation',
                    'details' => 'Visited route: ' . $currentRoute,
                    'ip_address' => $request->ip(),
                ]);

                // Store the current route in the session for future comparison
                session(['previous_route' => $currentRoute]);
            }
        }

        return $next($request);
    }
}
