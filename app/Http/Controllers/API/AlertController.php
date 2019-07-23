<?php

namespace App\Http\Controllers\API;

use App\Models\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlertController extends Controller
{

    public function createAlert( Request $request )
    {

        // Add google recaptcha for guests
        $rules = Alert::$rules;
        if ( \Auth::guest() ) {
            $rules = array_merge( $rules, [
                'g-recaptcha-response' => 'required|captcha',
            ] );
        }

        $this->validate( $request, $rules );

        $data = $request->except( 'g-recaptcha-response' );
        $data['travel_date'] = Carbon::createFromFormat( "d/m/Y",$data['travel_date']);

        // Check if already exists
        $query =  $alert = Alert::where('travel_date',$data['travel_date'])
                                ->where('departure_city',$data['departure_city'])
                                ->where('arrival_city',$data['arrival_city']);
        if (\Auth::guest()) {
            $alert = $query->where('email',$data['email'])->first();
        } else {
            $alert = $query->where('user_id',\Auth::id())->first();
        }

        if ($alert) {
            return response([
                'status' => 'error',
                'message' => __('tickets.alerts.duplicate_alert')
            ],400);
        }

        Alert::create( $data );

        return [
            'status' => 'success',
            'message' => "Alert created."
        ];

    }

}
