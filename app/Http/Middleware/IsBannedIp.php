<?php

namespace App\Http\Middleware;

use App\Models\Ban;
use App\Models\Ip;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBannedIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isBanned = Ip::query()->where([
            'ip' => $request->getClientIp(),
            'banned' => true
        ])->exists();

        if ($isBanned) {
            return response()->json(['message' => 'You IP is banned'], 403);
        }

        return $next($request);
    }
}
