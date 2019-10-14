<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller
{
    /**
     * Link to delete alert from emails.
     */
    public function deleteAlertPublic( Request $request, $alert_id, $hash )
    {
        $decodedId = \Hashids::decode( $hash );
        if ( ! isset( $decodedId[0] ) || $decodedId[0] != $alert_id ) {
            flash()->error( __( 'common.error' ) );

            return redirect()->route( 'home' );
        }

        // Check alert exists
        $alert = Alert::find( $alert_id );
        if ( ! $alert ) {
            flash()->error( __( 'common.error' ) );

            return redirect()->route( 'home' );
        }

        $alert->delete();
        flash()->success( __( 'tickets.alerts.success_delete' ) );

        return redirect()->route( 'home' );

    }
}
