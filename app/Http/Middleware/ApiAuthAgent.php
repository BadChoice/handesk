<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;

class ApiAuthAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! request()->hasHeader('token')) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }
        $agent = User::where('token', request()->header('token'))->first();
        if (! $agent) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }
        auth()->login($agent);

        return $next($request);
    }
}
