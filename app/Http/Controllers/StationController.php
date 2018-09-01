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
        $res = $tnt->search( $nameTrigram, 20 );
        $keys = collect( $res['ids'] )->values()->all();

        // If secund name, also search for it
        if ( $secundNameTrigram ) {
            $res = $tnt->search( $secundNameTrigram, 20 );
            $keys = array_merge( $keys, collect( $res['ids'] )->values()->all() );
        }

        $stations = Station::whereIn( 'id', $keys )->get();

        return $this->sortResults($stations,$name,$secundName);
    }

    /**
     * Sort given stations
     *
     * @param      $stations
     * @param      $name
     * @param null $secundName
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    private function sortResults($stations,$name,$secundName=null) {
        // Find parent station
        $parentStation = [];
        $maxParentStation = [
            "value" => 0,
            "id" => null
        ];


        $stations->map( function ( $station ) use ( $name, $secundName,&$parentStation, &$maxParentStation ) {
            $station->similarity = $this->calculateSimilarity( $station, $name, $secundName );
            // Count parent station
            if ($station->parent_station_id!=null) {
                if (isset($parentStation[$station->parent_station_id])){
                    $parentStation[$station->parent_station_id]++;
                } else {
                    $parentStation[$station->parent_station_id] = 1;
                }

                // Set max parent station
                if ($parentStation[$station->parent_station_id] > $maxParentStation['value']) {
                    $maxParentStation['value'] = $parentStation[$station->parent_station_id];
                    $maxParentStation['id'] = $station->parent_station_id;
                }
            }
        } );

        $sorted = $stations->sort( function ( $a, $b ) use ( $name, $secundName, $parentStation, $maxParentStation ) {

            // Now we want station child of main one to be first as well
            if ($a->id == $maxParentStation["id"]) {
                return 1;
            } else if ($b->id == $maxParentStation["id"] ) {
                return -1;
            }

            // Compare parent station
            if (isset($parentStation[$a->id]) && isset($parentStation[$b->id])) {
                return $parentStation[$a->id] < $parentStation[$b->id] ?  -1 : 1;
            }

            // Now we want station child of main one to be first as well
            if ($a->parent_station_id == $maxParentStation["id"] && $b->parent_station_id != $maxParentStation["id"]) {

                return 1;

            } else if ($b->parent_station_id == $maxParentStation["id"] && $a->parent_station_id != $maxParentStation["id"]) {

                return -1;
            }

            if ( $a->similarity === $b->similarity ) {

                return 0;

            }

            return $a->similarity < $b->similarity ? - 1 : 1;
        } );

        return StationRessource::collection( $sorted->reverse()->take( 15 ) );
    }

    /**
     * Calculate similarity between station name and string.
     *
     * Uses an average between similar_text and function compareStrings below
     */
    private function calculateSimilarity( $station, $name, $secundName = null )
    {
        $stationName = \App\Facades\AppHelper::removeAccents( strtolower( $station->name ) );
        $stationNameFR = $station->name_fr ? \App\Facades\AppHelper::removeAccents( strtolower( $station->name_fr ) ) : null;
        $stationNameEN = $station->name_en ? \App\Facades\AppHelper::removeAccents( strtolower( $station->name_en ) ) : null;

        $percentage = 0;
        $percentageFr = 0;
        $percentageEn = 0;
        $percentageSecund = 0;
        $percentageSecundFr = 0;
        $percentageSecundEn = 0;

        similar_text( $stationName, $name, $percentage );
        similar_text( $stationNameFR, $name, $percentageFr );
        similar_text( $stationNameEN, $name, $percentageEn );

        // Secund method to make average
        $percentage = ($percentage + $this->compareStrings($stationName,$name)) / 2;
        $percentageFr = ($percentageFr + $this->compareStrings($stationNameFR,$name)) / 2;
        $percentageEn = ($percentageEn + $this->compareStrings($stationNameEN,$name)) / 2;

        if ( $secundName ) {
            similar_text( $stationName, $secundName, $percentageSecund );
            similar_text( $stationNameFR, $secundName, $percentageSecundFr );
            similar_text( $stationNameEN, $secundName, $percentageSecundEn );

            // Secund method to make average
            $percentageSecund = ($percentage + $this->compareStrings($stationName,$secundName)) / 2;
            $percentageSecundFr = ($percentageFr + $this->compareStrings($stationNameFR,$secundName)) / 2;
            $percentageSecundEn = ($percentageEn + $this->compareStrings($stationNameEN,$secundName)) / 2;
        }

        return max( $percentage, $percentageFr, $percentageEn, $percentageSecund, $percentageSecundFr, $percentageSecundEn );
    }

    /**
     * Secund method to calculate similarity. Helpful to also consider string lenght
     *
     * @param $s1
     * @param $s2
     *
     * @return float|int
     */
    private function compareStrings( $s1, $s2 )
    {
        //one is empty, so no result
        if ( strlen( $s1 ) == 0 || strlen( $s2 ) == 0 ) {
            return 0;
        }

        //replace none alphanumeric charactors
        //i left - in case its used to combine words
        $s1clean = preg_replace( "/[^A-Za-z0-9-]/", ' ', $s1 );
        $s2clean = preg_replace( "/[^A-Za-z0-9-]/", ' ', $s2 );

        //remove double spaces
        while ( strpos( $s1clean, "  " ) !== false ) {
            $s1clean = str_replace( "  ", " ", $s1clean );
        }
        while ( strpos( $s2clean, "  " ) !== false ) {
            $s2clean = str_replace( "  ", " ", $s2clean );
        }

        //create arrays
        $ar1 = explode( " ", $s1clean );
        $ar2 = explode( " ", $s2clean );
        $l1 = count( $ar1 );
        $l2 = count( $ar2 );

        //flip the arrays if needed so ar1 is always largest.
        if ( $l2 > $l1 ) {
            $t = $ar2;
            $ar2 = $ar1;
            $ar1 = $t;
        }

        //flip array 2, to make the words the keys
        $ar2 = array_flip( $ar2 );


        $maxwords = max( $l1, $l2 );
        $matches = 0;

        //find matching words
        foreach ( $ar1 as $word ) {
            if ( array_key_exists( $word, $ar2 ) ) {
                $matches ++;
            }
        }

        return ( $matches / $maxwords ) * 100;
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
