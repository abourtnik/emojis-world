<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\HttpFoundation\Response;

class BlockBot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $crawlerDetect = new CrawlerDetect();

        if ($crawlerDetect->isCrawler($request->userAgent())) {
            return response()->json(['message' => 'Bot detected'], 403);
        }

        return $next($request);
    }
}
