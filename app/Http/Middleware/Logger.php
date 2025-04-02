<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->get('ip')?->ignored) {
            return $response;
        }

        Log::create([
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'response_status' => $response->getStatusCode(),
            'response_time' => intval((microtime(true) - LARAVEL_START) * 1000),
            'date' => now(),
            'ip' => $request->getClientIp(),
            'user_agent' => Str::limit($request->userAgent(), 255, ''),
        ]);

        return $response;
    }
}
