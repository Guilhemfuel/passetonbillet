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
    protected $searchable = false;


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainRequest $request)
    {
        $train = new Train($request->all());
        $train->save();

        flash()->success($this->CRUDsingularEntityName . ' created!');
        return redirect()->route($this->CRUDmodelName.'.edit',$train->id);
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
        $train = Train::find($id);
        if (!$train){
            \Session::flash('danger','Entity not found!');
            return redirect()->back();
        }
        $train->update($request->all());
        $train->save();
        flash()->success($this->CRUDsingularEntityName . ' updated!');
        return redirect()->route($this->CRUDmodelName.'.edit',$train->id);
    }

}
