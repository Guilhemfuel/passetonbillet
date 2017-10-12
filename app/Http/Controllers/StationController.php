<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;

class StationController extends Controller
{

    /////////////////////////
    /// API
    /////////////////////////

    /**
     * Returns a list of stations
     *
     * @return string
     */
    public function stations(){
        if (\App::isLocale('fr')) {
            return \GuzzleHttp\json_encode( Station::orderBy('name_fr')->pluck('id','name_fr'));
        } else {
            return \GuzzleHttp\json_encode( Station::orderBy('name_en')->pluck('id','name_en'));
        }
    }
}
