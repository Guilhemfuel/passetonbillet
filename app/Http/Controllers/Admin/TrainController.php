<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TrainRequest;
use App\Train;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrainController extends BaseController
{

    protected $CRUDmodelName = 'trains';
    protected $CRUDsingularEntityName = 'Train';

    protected $model = Train::class;


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainRequest $request)
    {
        $train = new Train($request->all());
        dd($train);die;

        $train->save();

        \Session::flash('success',$this->CRUDsingularEntityName.' created!');
        return redirect()->route($this->CRUDmodelName.'.show',$train->id);
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
}
