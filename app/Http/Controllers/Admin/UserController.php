<?php

namespace App\Http\Controllers\Admin;

use App\Models\Verification\IdVerification;
use App\Notifications\Verification\IdConfirmed;
use App\Notifications\Verification\IdDenied;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Exceptions\LastarException;

class UserController extends BaseController
{

    protected $CRUDmodelName = 'users';
    protected $CRUDsingularEntityName = 'User';

    protected $model = User::class;

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

        \Session::flash( 'success', $this->CRUDsingularEntityName . ' created!' );

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
        \Session::flash( 'success', $this->CRUDsingularEntityName . ' updated!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }

    /**
     * Get the oldest id check request
     */
    public function getOldestIdCheck()
    {
        $idCheck = IdVerification::where('accepted',null)->oldest()->first();

        if ( $idCheck == null ) {
            \Session::flash( 'danger', 'No id check is awaiting.' );

            return redirect()->route( 'admin.home' );
        }

        return view( 'admin.unique.verification.id' )->with( [ 'user' => $idCheck->user ] );
    }

    /**
     * Accept an Id Verification
     */
    public function acceptIdVerification( Request $request )
    {
        $request->validate( [
            'verification_id' => 'required|exists:id_verifications,id'
        ] );

        $idVerif = IdVerification::find( $request->verification_id );
        $idVerif->accepted = true;
        $idVerif->save();

        $idVerif->user->notify( new IdConfirmed() );

        \Session::flash( 'success', 'ID confirmed!' );

        return redirect()->route( 'id_check.oldest' );
    }

    // ----------- ID Verification -----------

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
        $idVerif->accepted = false;
        $idVerif->comment = $request->comment;
        $idVerif->save();

        $idVerif->user->notify( new IdDenied($idVerif->comment) );

        $idVerif->delete();

        \Session::flash( 'success', 'ID successfully Denied!' );

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
