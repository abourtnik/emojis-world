<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AssignVisitorId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cookies->has('visitor_id')) {
            return $next($request);
        }

        $visitorId = (string) Str::uuid();

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        return $response->cookie('visitor_id', $visitorId, 60 * 24 * 365 * 20); // 20 years

    }
}
