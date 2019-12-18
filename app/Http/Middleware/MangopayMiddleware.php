<?php

namespace App\Http\Middleware;

use Closure;

class MangopayMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $whitelist = [
            '23.100.12.200',
        ];

        if (!in_array($request->ip(), $whitelist)) {
            return redirect('home');
        }

        return $next($request);
    }
}
