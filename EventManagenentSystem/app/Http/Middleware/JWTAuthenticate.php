<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticate
{
    public function handle($request, Closure $next)
    {
        \Log::info('Entering JWT Middleware');

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                \Log::info('User not found');
                return response()->json(['message' => 'User not found'], 404);
            }
            \Log::info('User authenticated', ['user' => $user]);
        } catch (JWTException $e) {
            \Log::error('Token error', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Token is invalid'], 401);
        }

        return $next($request);
    }
}
