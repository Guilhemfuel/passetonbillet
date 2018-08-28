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
                           ->get();

        return StationRessource::collection( $stations->sortBy(function($station) {
            return strlen($station->name);
        } ));
    }

    /**
     * Returns a list of stations
     *
     * @return string
     */
    public function show( $stationId)
    {
        $station = Station::findOrFail($stationId);

        return new StationRessource($station);
    }
}
