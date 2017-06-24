<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PageController extends Controller
{

    public function home()
    {
        if ( \Auth::check() ) {
            return view( 'home' );

        } else {
            return view( 'welcome' );
        }
    }

}
