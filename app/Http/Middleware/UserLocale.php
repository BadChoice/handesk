<?php

namespace App\Http\Middleware;

use Closure;

class UserLocale
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
        app()->setLocale(auth()->user()->locale);

        return $next($request);
    }
}
