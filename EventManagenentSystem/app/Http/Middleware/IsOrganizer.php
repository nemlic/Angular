<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsOrganizer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'organizer') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
