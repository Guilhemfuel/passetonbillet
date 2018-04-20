<?php

namespace App\Http\Middleware;

use Closure;

class ForbidBanUsersMiddleware
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

        if ( \Auth::check() && \Auth::user()->banned ) {
            \Auth::logout();
            \Session::flash('error',__('common.error'));
            return redirect()->route( 'home' );
        }

        return $next($request);
    }
}
