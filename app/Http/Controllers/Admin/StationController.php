<?php

namespace App\Http\Controllers\Admin;

use App\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StationController extends BaseController
{
    protected $CRUDmodelName = 'stations';
    protected $CRUDsingularEntityName = 'Station';

    protected $model = Station::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // ----- API -----

    public function stations(){
        if (\App::isLocale('fr')) {
            return \GuzzleHttp\json_encode( Station::orderBy('name_fr')->pluck('id','name_fr'));
        } else {
            return \GuzzleHttp\json_encode( Station::orderBy('name_en')->pluck('id','name_en'));
        }
    }

}
