<?php

namespace App\Http\Middleware\Verified;

use Closure;

class Phone
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
        if ( ! \Auth::check() || ! \Auth::user()->phone_verified ) {
            \Session::flash('error','You must verify your phone number first!');
            return redirect()->route( 'home' );
        }

        return $next($request);
    }
}
