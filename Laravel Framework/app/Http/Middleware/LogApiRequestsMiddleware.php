<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApiRequestsMiddleware
{
    /**
     * Handle an incoming API request and log metadata.
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = round((microtime(true) - $startTime) * 1000, 2);

        Log::info('API Request Logged', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_id' => $request->user() ? $request->user()->id : 'Guest',
            'status' => $response->getStatusCode(),
            'duration_ms' => $duration,
        ]);

        return $response;
    }
}
