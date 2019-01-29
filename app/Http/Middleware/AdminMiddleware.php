<?php

namespace App\Http\Middleware;

use Closure;
use Debugbar;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        if ( ! Auth::check() || ! Auth::user()->isAdmin() ) {
            \Session::flash('error','You can not be there.');
            return redirect()->route( 'home' );
        }

        $request->session()->put('eyewitness:auth', 1);

        return $next( $request );
    }
}
