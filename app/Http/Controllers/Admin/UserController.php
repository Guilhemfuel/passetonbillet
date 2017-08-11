<?php

namespace App\Http\Controllers\Admin;

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
        $user = new User($request->all());
        $user->password = bcrypt(str_random(25));
        $user->status = -1;
        $user->save();

        \Session::flash('success',$this->CRUDsingularEntityName.' created!');
        return redirect()->route($this->CRUDmodelName.'.edit',$user->id);
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
        $user = User::find($id);
        if (!$user){
            \Session::flash('danger','Entity not found!');
            return redirect()->back();
        }
        $user->update($request->all());
        $user->save();
        \Session::flash('success',$this->CRUDsingularEntityName.' updated!');
        return redirect()->route($this->CRUDmodelName.'.edit',$user->id);
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
    public function searchAPI(Request $request, $name )
    {
        $users = User::search($name)->take(10)->get();
        $response = [];
        foreach ($users as $user){
            array_push($response,['label'=>$user->full_name,'value'=>$user->id]);
        }
        return \GuzzleHttp\json_encode($response);
    }

}
