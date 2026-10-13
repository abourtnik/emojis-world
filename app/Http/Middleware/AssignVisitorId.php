<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AssignVisitorId
{
    public const string COOKIE_NAME = 'visitor_id';
    public const int COOKIE_LIFETIME = 60 * 24 * 365 * 20; // 20 years

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cookies->has(self::COOKIE_NAME)) {
            return $next($request);
        }

        $visitorId = (string) Str::uuid();

        $request->cookies->set(self::COOKIE_NAME, $visitorId);

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        return $response->cookie(self::COOKIE_NAME, $visitorId, self::COOKIE_LIFETIME);
    }
}
