<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRessource;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user;

    public function __construct()
    {
        $this->middleware( function ( $request, $next ) {
            if ( \Auth::check() ) {
                $this->user = \Auth::user();
                view()->share( 'user', new UserRessource( $this->user ) );
                view()->share( 'userData', new UserRessource( $this->user ) );
            }

            return $next( $request );
        } );
    }
}
