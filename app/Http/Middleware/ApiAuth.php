<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request()->header('token') !== env('API_TOKEN', 'the-api-token')) {
            return response()->json(['error' => 'unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
