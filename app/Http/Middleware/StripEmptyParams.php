<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class StripEmptyParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $query = $request->query();

        $cleanQuery = array_filter($query, fn($value) => !is_null($value));

        if (count($query) === count($cleanQuery)) {
            return $next($request);
        }

        return redirect()->route($request->route()->getName(), $cleanQuery);
    }
}
