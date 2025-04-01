<?php

namespace App\Http\Middleware;

use App\Models\Ip;
use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
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

        $isIgnored = Ip::query()->where([
            'ip' => $request->getClientIp(),
            'ignored' => true
        ])->exists();

        if ($isIgnored) {
            return $response;
        }

        Log::query()
            ->create([
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'response_status' => $response->getStatusCode(),
                'response_time' => intval((microtime(true) - LARAVEL_START) * 1000),
                'date' => now(),
                'ip' => $request->getClientIp(),
                'user_agent' => $request->userAgent(),
            ]);

        return $response;
    }
}
