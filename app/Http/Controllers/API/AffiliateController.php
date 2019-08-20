<?php

namespace App\Http\Controllers\API;

use App\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\ScnfAffiliate;

class AffiliateController extends Controller
{

    public function sncfAffiliate( Request $request )
    {
        $this->validate( $request, [
            'departure_station' => 'required|integer|exists:stations,id',
            'arrival_station'   => 'required|integer|exists:stations,id',
            'trip_date'         => 'required|date_format:d/m/Y|after:yesterday',
        ] );

        $departureStation = Station::find( $request->get( 'departure_station' ) );
        $arrivalStation = Station::find( $request->get( 'arrival_station' ) );

        // Take parent stations
        if ($departureStation->parent_station_id) {
            $departureStation = Station::find($departureStation->parent_station_id);
        }
        if ($arrivalStation->parent_station_id) {
            $arrivalStation = Station::find($arrivalStation->parent_station_id);
        }

        $date = Carbon::createFromFormat( 'd/m/Y', $request->get( 'trip_date' ) );
        $time = $request->get( 'trip_time', Carbon::now()->format( 'h:m' ) );

        return ScnfAffiliate::getProposals( $departureStation, $arrivalStation, $date, $time );
    }

}
