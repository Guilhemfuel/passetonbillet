<?php

namespace App\Http\Controllers;

use App\Facades\AppHelper;
use App\Facades\ImageHelper;
use App\Models\Verification\IdVerification;
use App\Models\Verification\PhoneVerification;
use App\Notifications\Verification\IdConfirmed;
use App\User;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class UserController extends Controller
{
    const ID_PATH = 'id_verification';

    /**
     * Upload
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadId( Request $request )
    {
        // Make sure user isn't verified or does not have a pending verification
        if($request->user()->id_verified || $request->user()->idVerification!=null){
            flash( __( 'profile.modal.verify_identity.error' ) )->error();

            return redirect()->route( 'public.profile.home' );
        }

        $data = $request->all();
        $data['user_id'] = \Auth::id();

        \Validator::make($data,IdVerification::rules() )->validate();

        $scan = $data['scan'];
        $scanFileType = $scan->getClientOriginalExtension();
        if (strtolower($scanFileType ) === 'pdf') {
            \Storage::disk('s3')->putFileAs('/'.self::ID_PATH.'/', $scan,IdVerification::userIdFileName(\Auth::user(),$scanFileType));
        } else {
            ImageHelper::resizeImageAndUploadToS3( 700, null, true, $request->scan, self::ID_PATH, IdVerification::userIdFileName(\Auth::user(),$scanFileType) );
        }

        $idVerif = new IdVerification( [
            'user_id' => \Auth::user()->id,
            'scan'    => self::ID_PATH.'/'.IdVerification::userIdFileName(\Auth::user(),$scanFileType),
            'type'    => $request->get('type'),
            'country' => $request->get('country')
        ] );
        $idVerif->save();

        flash( __( 'profile.modal.verify_identity.success' ) )->success();

        return redirect()->back();
    }

    /**
     * Change a user pwd
     *
     * @param Request $request
     */
    public function changePassword( Request $request )
    {
        $request->validate( [
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:8',
        ] );

        // Make sure current account password with right one
        if ( ! \Hash::check( $request->old_password, \Auth::user()->password ) ) {
            flash( __( 'profile.modal.change_password.flash.wrong_old_password' ) )->error();

            return redirect()->route( 'public.profile.home' );
        }

        $request->user()->fill( [
            'password' => \Hash::make( $request->password )
        ] )->save();

        flash( __( 'profile.modal.change_password.flash.success' ) )->success();

        return redirect()->route( 'public.profile.home' );
    }

    /**
     * @param Request $request
     */
    public function changeProfilePicture( Request $request )
    {
        $request->validate( [
            'picture' => 'required|image'
        ] );

        $user = \Auth::user();
        $user->picture = ImageHelper::fitImageAndUploadToS3( 200, $request->picture, 'avatar' );

        if ( ! filter_var( $user->picture, FILTER_VALIDATE_URL ) ) {
            flash( __( 'profile.modal.change_picture.error' ) )->error();

            return redirect()->route( 'public.profile.home' );
        }

        $user->save();

        flash( __( 'profile.modal.change_picture.success' ) )->success();

        return redirect()->route( 'public.profile.home' );
    }

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

        // Clean phone
        $phone = $request->phone;
        if ($phone[0]!='0'){
            $phone = '0'.$phone;
        }

        // Make sure no user already have the same phone
        if ( User::withTrashed()->where( 'phone', $phone )
                 ->where( 'phone_country', $request->phone_country )
                 ->count() > 0 ) {
            flash( __( 'tickets.sell.confirm_number.errors.phone_already_used' ) )->error();

            return redirect()->back();
        }

        // Make sure user doesn't have a phone yet
        if ( $request->user()->phone_verified ) {
            flash( __( 'tickets.sell.confirm_number.errors.phone_already_verified' ) )->error();

            return redirect()->back();
        }

        // Now we make sure that verificaton wasn't sent more than 3 times for one user
        if ( PhoneVerification::withTrashed()->where( 'user_id', $request->user()->id )->count() > 2 ) {
            flash( __( 'tickets.sell.confirm_number.errors.verify_max_retry' ) )->error();

            return redirect()->back();
        }

        // Now if we call this function again (ie reverify) we delete previous instance of PhoneVerif
        $oldActivePhoneVerification = PhoneVerification::where( 'user_id', $request->user()->id )->first();
        if ( $oldActivePhoneVerification ) {
            $oldActivePhoneVerification->delete();
        }

        $phoneVerification = new PhoneVerification(
            [
                'phone'         => $phone,
                'phone_country' => $request->phone_country,
                'code'          => rand( 100000, 999999 ),
                'user_id'       => $request->user()->id
            ] );

        if ( \App::environment( 'production', 'staging' ) ) {
            try {
                Nexmo::message()->send( [
                    'to'   => $phoneVerification->phone_number,
                    'from' => config( 'nexmo.send_from' ),
                    'text' => $phoneVerification->message
                ] );
            } catch (\Exception $e){
                flash(__('common.error'))->error();
                return redirect()->back();
            }
        }

        $phoneVerification->save();

        flash( __( 'tickets.sell.confirm_number.success.code_sent' ) )->success();

        return redirect()->back();

    }

    /**
     * Post sms verification code to make sure of the number
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function verifyPhone( Request $request )
    {

        $request->validate( [
            'code' => 'required|numeric',
        ] );

        // Make sure user doesn't have a phone yet
        if ( $request->user()->phone_verified ) {
            flash( __( 'tickets.sell.confirm_number.errors.phone_already_verified' ) )->error();

            return redirect()->back();
        }

        // Make sure we can find a verification code
        $phoneVerification = PhoneVerification::where( 'user_id', $request->user()->id )
                                              ->where( 'code', $request->code )
                                              ->first();

        if ( ! $phoneVerification ) {
            flash( __( 'tickets.sell.confirm_number.errors.no_verification_found' ) )->error();

            return redirect()->back();
        }

        // Make sure no user already have the same phone
        if ( User::where( 'phone', $phoneVerification->phone )
                 ->where( 'phone_country', $phoneVerification->phone_country )
                 ->count() > 0 ) {
            flash( __( 'tickets.sell.confirm_number.errors.phone_already_used' ) )->error()->important();

            return redirect()->back();
        }

        // Now we save the phone number
        $user = $request->user();
        $user->phone = $phoneVerification->phone;
        $user->phone_country = $phoneVerification->phone_country;
        $user->save();

        $phoneVerification->delete();

        flash( __( 'tickets.sell.confirm_number.success.number_confirmed' ) )->success();

        return redirect()->back();

    }

    //////////////////////////
    /// API
    /// /////////////////

    /**
     * Return unread notifications and mark them as read
     *
     * @param Request $request
     *
     * @return string
     */
    public function getNotifications( Request $request )
    {
        $unread_notifications = \Auth::user()->unreadNotifications;
        $jsonNotificationContent = [];

        foreach ($unread_notifications as $notification) {
            array_push( $jsonNotificationContent , $notification->data );
            $notification->markAsRead();
        }

        return \GuzzleHttp\json_encode($jsonNotificationContent);

    }

}
