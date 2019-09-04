<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\IdAcceptedEvent;
use App\Http\Resources\UserRessource;
use App\Models\Verification\IdVerification;
use App\Notifications\Verification\IdConfirmed;
use App\Notifications\Verification\IdDenied;
use App\Rules\Country;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Exceptions\PasseTonBilletException;
use Psy\Util\Str;

class UserController extends BaseController
{

    protected $CRUDmodelName = 'users';
    protected $CRUDsingularEntityName = 'User';

    protected $creatable = false;

    protected $model = User::class;

    const ADMIN_IMPERSONATE_COOKIE_NAME = 'ptb-admin-impersonate';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( UserRequest $request )
    {
        $user = new User( $request->all() );
        $user->password = bcrypt( str_random( 25 ) );
        $user->email_verified = false;
        $user->status = - 1;
        $user->save();

        flash()->success( $this->CRUDsingularEntityName . ' created!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        $user = User::find( $id );
        if ( ! $user ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }
        $user->update( $request->all() );
        $user->save();

        flash()->success( $this->CRUDsingularEntityName . ' updated!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }

    /**
     * Get the oldest id check request
     */
    public function getOldestIdCheck()
    {
        $idCheck = IdVerification::where( 'accepted', null )->oldest()->first();

        if ( $idCheck == null ) {

            flash( 'No id check is awaiting.' )->error();

            return redirect()->route( 'admin.home' );
        }

        return view( 'admin.unique.verification.id' )->with(
            [
                'user'   => $idCheck->user,
                'jsUser' => new UserRessource( $idCheck->user )
            ] );
    }

    // ---- Verify user having troubles with email ----

    public function verifyUser( Request $request, $id )
    {
        $user = User::find( $id );
        if ( ! $user ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }

        if ( $user->status != User::STATUS_UNCONFIRMED_USER ) {
            \Session::flash( 'danger', 'User is not in the unconfirmed state, cannot be activated' );

            return redirect()->back();
        }

        $user->email_verified = true;
        $user->status = User::STATUS_USER;
        $user->email_token = null;

        $user->save();

        flash( 'User account activated.' )->success();

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }


    // ---------- Ban User -------

    public function banUser( Request $request, $id )
    {
        $user = User::find( $id );
        if ( ! $user ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }

        if ( $user->status != User::STATUS_USER ) {
            \Session::flash( 'danger', 'Only active user (non admin) can be banned!' );

            return redirect()->back();
        }

        $user->status = User::STATUS_BANNED_USER;
        $user->save();

        flash( 'User banned.' )->success();

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }

    // ----------- Impersonate ------

    public function impersonate( Request $request, $id )
    {
        $user = User::find( $id );
        if ( ! $user ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }

        // Set cookie to be able to come back to admin fast
        $ip = $request->ip();
        $adminId = \Auth::user()->id;
        $random = \Illuminate\Support\Str::random( 30 );

        $hash = bcrypt( $adminId . $random);
        $secret = $ip . $hash;

        \Cache::put( $secret, $adminId, now()->addMinutes(60) );
        \Cookie::queue(\Cookie::forget(\App\Http\Controllers\Admin\UserController::ADMIN_IMPERSONATE_COOKIE_NAME));
        cookie()->queue(self::ADMIN_IMPERSONATE_COOKIE_NAME, $hash, 60);

        auth()->login( $user );

        flash()->info('You are now acting as ' . $user->full_name . '.');

        return redirect()->route( 'home' );
    }

    // ----------- ID Verification -----------

    /**
     * Accept an Id Verification
     */
    public function acceptIdVerification( Request $request )
    {
        $request->validate( [
            'verification_id' => 'required|exists:id_verifications,id',
            'birthdate'       => 'required|date_format:d/m/Y',
            'first_name'      => 'required',
            'last_name'       => 'required',
            'type'            => [ 'required', 'in:' . implode( ',', IdVerification::DOCUMENT_TYPES ) ],
            'country'         => [ 'required', new Country() ],
        ] );

        $idVerif = IdVerification::find( $request->verification_id );

        if ( $idVerif->accepted != null ) {

            flash()->error( 'ID confirmation already done!' );

            return redirect()->route( 'id_check.oldest' );
        }

        $idVerif->type = $request->get( 'type' );
        $idVerif->country = $request->get( 'country' );
        $idVerif->accepted = true;
        $idVerif->save();

        $idVerif->user->notify( new IdConfirmed() );

        // Now we update user info
        $idVerif->user->update( $request->except( [ 'verification_id', 'type', 'country' ] ) );

        // Dispatch the event
        event( new IdAcceptedEvent( $idVerif ) );

        flash()->success( 'ID confirmed!' );

        return redirect()->route( 'id_check.oldest' );
    }

    /**
     * Deny an Id Verification
     */
    public function denyIdVerification( Request $request )
    {
        $request->validate( [
            'verification_id' => 'required|exists:id_verifications,id',
            'comment'         => 'required'
        ] );

        $idVerif = IdVerification::find( $request->verification_id );

        if ( $idVerif->accepted != null ) {

            flash()->error( 'ID confirmation already done!' );

            return redirect()->route( 'id_check.oldest' );
        }

        $idVerif->accepted = false;
        $idVerif->comment = $request->comment;
        $idVerif->save();

        $idVerif->user->notify( new IdDenied( $idVerif->comment ) );

        $idVerif->delete();

        flash()->success( 'ID successfully Denied!' );

        return redirect()->route( 'id_check.oldest' );
    }

    // ---------- API --------------

    /**
     * Return Json of 10 users matching search request
     *
     * @param Request $request
     * @param         $name
     *
     * @return string
     */
    public function searchAPI( Request $request, $name )
    {
        $users = User::search( $name )->take( 10 )->get();
        $response = [];
        foreach ( $users as $user ) {
            array_push( $response, [ 'label' => $user->full_name, 'value' => $user->id ] );
        }

        return \GuzzleHttp\json_encode( $response );
    }

}
