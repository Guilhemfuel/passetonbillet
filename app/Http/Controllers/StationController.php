<?php

namespace App\Http\Controllers;

use App\Helper\AppHelper;
use App\Http\Resources\StationRessource;
use Illuminate\Http\Request;
use App\Station;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;
use TeamTNT\TNTSearch\TNTSearch;

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

        if ( ! $request->has( 'name' ) ) {
            return [];
        }

        $stations = Station::search( $request->name)->get();

        return StationRessource::collection( $stations );
    }

    /**
     * Returns a list of stations
     *
     * @return string
     */
    public function show( $stationId )
    {
        $station = Station::findOrFail( $stationId );

        return new StationRessource( $station );
    }
}
