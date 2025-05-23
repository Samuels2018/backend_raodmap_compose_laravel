<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (Auth::guard('api')->check() && Auth::guard('api')->user()->isAdmin()) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized - Admin access required'], 403);
    }
}
