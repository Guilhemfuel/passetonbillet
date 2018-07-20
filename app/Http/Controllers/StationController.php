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

        $searchName = '%' . strtolower( $request->name ) . '%';

        if ( \App::isLocale( 'fr' ) ) {
            $stations = Station::whereRaw( "LOWER(name_fr) LIKE ?", [ $searchName ] )
                               ->orderBy( 'name_fr' )->get();
        } else {
            $stations = Station::whereRaw( "LOWER(name_en) LIKE ?", [ $searchName ] )
                               ->orderBy( 'name_en' )->get();
        }

        return StationRessource::collection( $stations );
    }
}
