<?php

namespace App\Http\Controllers;

use App\Http\Resources\StationRessource;
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
    public function stationSearch( Request $request )
    {
        if ( ! $request->name ) {
            return [];
        }

        $stations = Station::search(  $request->name )
                           ->orderBy( 'name' )
                           ->get();

        return StationRessource::collection( $stations );
    }
}
