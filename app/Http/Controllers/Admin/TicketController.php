<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TicketRequest;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends BaseController
{
    protected $CRUDmodelName = 'tickets';
    protected $CRUDsingularEntityName = 'Ticket';

    protected $model = Ticket::class;
    protected $creatable = true;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ticket = factory(Ticket::class)->make();
        $admin = User::where('status',100)->first();
        if (!$admin) {
            flash('No admin found!')->error();
            return redirect()->back();
        }

        $ticket->user_id = $admin->id;
        $ticket->save();

        flash()->success($this->CRUDsingularEntityName.' created! Admin owner is: '.$admin->full_name);
        return redirect()->route($this->CRUDmodelName.'.edit',$ticket->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        flash()->success($this->CRUDsingularEntityName.' can\'t be created like that!');
        return redirect()->route($this->CRUDmodelName);
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
