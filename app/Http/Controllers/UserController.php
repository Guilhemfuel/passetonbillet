<?php

namespace App\Http\Controllers;

use App\Models\Verification\PhoneVerification;
use App\User;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class UserController extends Controller
{

    /**
     * Send user a verification code via SMS
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPhone( Request $request )
    {

        $request->validate( [
            'phone'         => 'required',
            'phone_country' => 'required',
        ] );

        // Make sure no user already have the same phone
        if ( User::where( 'phone', $request->phone )
                 ->where( 'phone_country', $request->phone_country )
                 ->count() > 0 ) {
            flash( __('tickets.sell.confirm_number.errors.phone_already_used') )->error();

            return redirect()->back();
        }

        // Make sure user doesn't have a phone yet
        if ( $request->user()->phone_verified ) {
            flash( __('tickets.sell.confirm_number.errors.phone_already_verified') )->error();

            return redirect()->back();
        }

        // Now we make sure that verificaton wasn't sent more than 3 times for one user
        if ( PhoneVerification::withTrashed()->where( 'user_id', $request->user()->id )->count() > 2 ) {
            flash( __('tickets.sell.confirm_number.errors.verify_max_retry') )->error();

            return redirect()->back();
        }

        // Now if we call this function again (ie reverify) we delete previous instance of PhoneVerif
        $oldActivePhoneVerification = PhoneVerification::where( 'user_id', $request->user()->id )->first();
        if ( $oldActivePhoneVerification ) {
            $oldActivePhoneVerification->delete();
        }

        $phoneVerification = new PhoneVerification(
            [
                'phone'         => $request->phone,
                'phone_country' => $request->phone_country,
                'code'          => rand( 100000, 999999 ),
                'user_id'       => $request->user()->id
            ] );

        $phoneVerification->save();

        if (\App::environment('production', 'staging'))
        Nexmo::message()->send( [
            'to'   => $phoneVerification->phone_number,
            'from' => config('nexmo.send_from'),
            'text' => $phoneVerification->message
        ] );

        flash( __('tickets.sell.confirm_number.success.code_sent') )->success();

        return redirect()->back();

    }

    public function verifyPhone(Request $request){

        $request->validate( [
            'code'         => 'required|numeric',
        ] );

        // Make sure user doesn't have a phone yet
        if ( $request->user()->phone_verified ) {
            flash( __('tickets.sell.confirm_number.errors.phone_already_verified') )->error();
            return redirect()->back();
        }

        // Make sure we can find a verification code
        $phoneVerification = PhoneVerification::where('user_id',$request->user()->id)
                                              ->where('code',$request->code)
                                              ->first();

        if (!$phoneVerification) {
            flash( __('no_verification_found') )->error();
            return redirect()->back();
        }

        // Make sure no user already have the same phone
        if ( User::where( 'phone', $phoneVerification->phone )
                 ->where( 'phone_country', $phoneVerification->phone_country )
                 ->count() > 0 ) {
            flash( __('tickets.sell.confirm_number.errors.phone_already_used'))->error()->important();

            return redirect()->back();
        }

        // Now we save the phone number
        $user = $request->user();
        $user->phone = $phoneVerification->phone;
        $user->phone_country = $phoneVerification->phone_country;
        $user->save();

        $phoneVerification->delete();

        flash(__('number_confirmed'))->success();
        return redirect()->back();

    }

}
