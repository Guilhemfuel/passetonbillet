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

        $name = \AppHelper::removeAccents( $request->name );
        $nameTrigram = ( new TNTIndexer() )->buildTrigrams( $name );

        $tnt = new TNTSearch();

        $driver = config( 'database.default' );
        $config = config( 'scout.tntsearch' ) + config( "database.connections.$driver" );

        $tnt->loadConfig( $config );
        $tnt->setDatabaseHandle( app( 'db' )->connection()->getPdo() );

        $tnt->selectIndex( "stations.index" );
        $res = $tnt->search( $nameTrigram, 10 );
        $keys = collect( $res['ids'] )->values()->all();

        $stations = Station::whereIn( 'id', $keys )->get();

        $stations->map( function ( $station ) use ( $name ) {
            $station->distance = min(
                levenshtein( $name, $station->name ),
                levenshtein( $name, $station->name_fr ),
                levenshtein( $name, $station->name_en )
            );
        } );

        $sorted = $stations->sort( function ( $a, $b ) {
            if ( $a->distance === $b->distance ) {
                return 0;
            }

            return $a->distance < $b->distance ? - 1 : 1;
        } );

        return StationRessource::collection( $sorted );
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
