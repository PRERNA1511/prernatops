<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role = 'admin')
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('auth.login')->with('error', 'Please log in to access this area.');
        }

        if (auth()->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden: ' . ucfirst($role) . ' privileges required.'], 403);
            }
            abort(403, 'Unauthorized action. Requires ' . ucfirst($role) . ' role.');
        }

        return $next($request);
    }
}
