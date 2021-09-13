<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConsoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->user());
        return $next($request);
    }
}
