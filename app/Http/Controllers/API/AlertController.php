<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AlertResource;
use App\Models\Alert;
use App\User;
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
        $data['travel_date_start'] = Carbon::createFromFormat( "d/m/Y", $data['travel_date_start'] );
        $data['travel_date_end'] = Carbon::createFromFormat( "d/m/Y", $data['travel_date_end'] );

        // Check if date isn't past
        if ( $data['travel_date_start']->isPast() ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'tickets.alerts.past_alert' )
            ], 400 );
        }

        // Check that end date is not before start date
        if ( $data['travel_date_start']->isAfter( $data['travel_date_end'] ) ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'tickets.alerts.date_order' )
            ], 400 );
        }

        // Check if already exists
        $query = $alert = Alert::where( 'travel_date_start', $data['travel_date_start'] )
                               ->where( 'travel_date_end', $data['travel_date_end'] )
                               ->where( 'departure_city', $data['departure_city'] )
                               ->where( 'arrival_city', $data['arrival_city'] );
        if ( \Auth::guest() ) {
            $alert = $query->where( 'email', $data['email'] )->first();
        } else {
            $alert = $query->where( 'user_id', \Auth::id() )->first();
        }

        if ( $alert ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'tickets.alerts.duplicate_alert' )
            ], 400 );
        }

        // Finally check that email doesn't correspond to a user
        if ( ! \Auth::check() ) {
            $user = User::where( 'email', $request->email )->first();
            if ( $user ) {
                return response( [
                    'status'  => 'error',
                    'message' => __( 'tickets.alerts.existing_user' )
                ], 400 );
            }
        }

        $alert = Alert::create( $data );

        return [
            'status'  => 'success',
            'message' => "Alert created.",
            'alert'   => new AlertResource( $alert )
        ];

    }

    public function deleteAlert( $alert_id )
    {
        // Check alert exists
        $alert = Alert::find( $alert_id );
        if ( ! $alert ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'tickets.alerts.alert_not_found' )
            ], 400 );
        }

        // Check alert belongs to user
        if ( $alert->user_id != \Auth::id() ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'tickets.alerts.alert_not_found' )
            ], 400 );
        }

        $alert->delete();

        return [
            'status'  => 'success',
            'message' => __( 'tickets.alerts.success_delete' ),
        ];

    }

}
