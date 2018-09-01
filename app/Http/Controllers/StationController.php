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
        $name = strtolower( $name );
        $secundName = null;

        $nameTrigram = ( new TNTIndexer() )->buildTrigrams( $name );
        $secundNameTrigram = null;

        // If name starts with 'saint' or 'st', search for the other one
        if ( preg_match( "/^(saint)(\s|-)\w*/i", $name ) ) {
            $secundName = preg_replace( "/^(saint)\w*/i", "st", $name );
            $secundNameTrigram = ( new TNTIndexer() )->buildTrigrams( $secundName );
        } elseif ( preg_match( "/^(st)(\s|-)\w*/i", $name ) ) {
            $secundName = preg_replace( "/^(st)\w*/i", "saint", $name );
            $secundNameTrigram = ( new TNTIndexer() )->buildTrigrams( $secundName );
        }

        $tnt = new TNTSearch();

        $driver = config( 'database.default' );
        $config = config( 'scout.tntsearch' ) + config( "database.connections.$driver" );

        $tnt->loadConfig( $config );
        $tnt->setDatabaseHandle( app( 'db' )->connection()->getPdo() );

        $tnt->selectIndex( "stations.index" );
        $res = $tnt->search( $nameTrigram, 10 );
        $keys = collect( $res['ids'] )->values()->all();

        // If secund name, also search for it
        if ( $secundNameTrigram ) {
            $res = $tnt->search( $secundNameTrigram, 10 );
            $keys = array_merge( $keys, collect( $res['ids'] )->values()->all() );
        }

        $stations = Station::whereIn( 'id', $keys )->get();

        $stations->map( function ( $station ) use ( $name, $secundName ) {

            $stationName = \App\Facades\AppHelper::removeAccents($station->name);
            $stationNameFR = $station->name_fr ? \App\Facades\AppHelper::removeAccents($station->name_fr) : null;
            $stationNameEN = $station->name_en ? \App\Facades\AppHelper::removeAccents($station->name_en): null;

            if ( $secundName ) {
                $station->distance = min(
                    levenshtein( $name, $stationName, 2, 1, 2 ),
                    levenshtein( $name, $stationNameFR, 2, 1, 2 ),
                    levenshtein( $name, $stationNameEN, 2, 1, 2 ),
                    // test secund name distance
                    levenshtein( $secundName, $stationName, 2, 1, 2 ),
                    levenshtein( $secundName, $stationNameFR, 2, 1, 2 ),
                    levenshtein( $secundName, $stationNameEN, 2, 1, 2 )
                );
            } else {
                $station->distance = min(
                    levenshtein( $name, $stationName, 2, 1, 2 ),
                    levenshtein( $name, $stationNameFR, 2, 1, 2 ),
                    levenshtein( $name, $stationNameEN, 2, 1, 2 )
                );
            }
        } );


        $sorted = $stations->sort( function ( $a, $b ) use ( $name, $secundName ) {

            $stationNameA = \App\Facades\AppHelper::removeAccents($a->name);
            $stationNameB = \App\Facades\AppHelper::removeAccents($b->name);

            if ( $a->distance === $b->distance ) {
                // Priority to the one with the name closer (not help)
                $distanceA = levenshtein( $stationNameA, $name, 2, 1, 2 );
                $distanceB = levenshtein( $stationNameB, $name, 2, 1, 2 );

                // Also consider secund name
                if ($secundName) {
                    $distanceA = min($distanceA,levenshtein( $stationNameA, $secundName, 2, 1, 2 ));
                    $distanceB = min($distanceB,levenshtein( $stationNameB, $secundName, 2, 1, 2 ));
                }

                if ($distanceA === $distanceB) return 0;

                return $distanceA < $distanceB ? -1 : 1;
            }

            return $a->distance < $b->distance ? - 1 : 1;
        } );


        foreach ( $sorted as $station ) {
            echo \App\Facades\AppHelper::removeAccents($station->name) . ' ' . $station->name_fr . ' ' . $station->name_en . ' ' . $station->distance . '<br>';
        }

        return;

        return StationRessource::collection( $sorted->take( 10 ) );
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
