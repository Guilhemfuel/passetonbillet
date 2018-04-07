<?php

namespace App\Http\Controllers\Admin;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends BaseController
{
    protected $CRUDmodelName = 'tickets';
    protected $CRUDsingularEntityName = 'Ticket';

    protected $model = Ticket::class;
    protected $creatable = false;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        flash()->error('Ticket can\'t be created!');

        return redirect()->route($this->CRUDmodelName.'.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        flash()->error('Ticket can\'t be created!');
        return redirect()->route($this->CRUDmodelName.'.index');
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
        $ticket = Ticket::find($id);
        if (!$ticket){
            \Session::flash('danger','Entity not found!');
            flash()->error('Ticket not found!');
            return redirect()->back();
        }
        $ticket->update($request->all());
        $ticket->save();

        flash()->success('Ticket updated!');
        return redirect()->route($this->CRUDmodelName.'.edit',$ticket->id);
    }

}
