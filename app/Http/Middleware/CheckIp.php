<?php

namespace App\Http\Middleware;

use App\Models\Ip;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = Ip::query()->where('ip', $request->getClientIp())->first();

        return $next($request->merge(['ip' => $ip]));
    }
}
