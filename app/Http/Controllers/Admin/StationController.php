<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StationRequest;
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
    public function store(StationRequest $request)
    {
        $station = new Station($request->all());
        switch ($station->country){
            case 'fr':
                $station->timezone_txt = 'Europe/London';
                $station->timezone = '+01:00';
                break;
            case 'gb':
                $station->timezone_txt = 'Europe/Paris';
                $station->timezone = '+02:00';
                break;
            case 'be':
                $station->timezone_txt = 'Europe/Brussels';
                $station->timezone = '+02:00';
                break;
            default:
                \Session::flash('error','Country not found!');
                return redirect()->back();
        }
        $station->save();

        flash()->success($this->CRUDsingularEntityName.' created!');
        return redirect()->route($this->CRUDmodelName.'.edit',$station->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StationRequest $request, $id)
    {
        $station = Station::find($id);
        if (!$station){
            \Session::flash('danger','Entity not found!');
            return redirect()->back();
        }
        $station->update($request->all());
        switch ($station->country){
            case 'fr':
                $station->timezone_txt = 'Europe/London';
                $station->timezone = '+01:00';
                break;
            case 'gb':
                $station->timezone_txt = 'Europe/Paris';
                $station->timezone = '+02:00';
                break;
            case 'be':
                $station->timezone_txt = 'Europe/Brussels';
                $station->timezone = '+02:00';
                break;
            default:
                flash()->error('Country not found!');
                return redirect()->back();
        }
        $station->save();

        flash()->error($this->CRUDsingularEntityName.' created!');
        return redirect()->route($this->CRUDmodelName.'.edit',$station->id);
    }

}
