<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TicketRequest;
use App\Models\Discussion;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionController extends BaseController
{
    protected $CRUDmodelName = 'offers';
    protected $CRUDsingularEntityName = 'Offer';

    protected $model = Discussion::class;
    protected $creatable = false;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        flash()->error($this->CRUDsingularEntityName.' can\'t be created!');
        return redirect()->route($this->CRUDmodelName);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        flash()->error($this->CRUDsingularEntityName.' can\'t be created!');
        return redirect()->route($this->CRUDmodelName);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelDeny(Request $request, $id)
    {
        $entity = Discussion::find($id);
        if (!$entity){
            flash()->error('Offer not found!');
            return redirect()->back();
        }

        if ($entity->status != Discussion::DENIED){
            flash('Can\'t undeny a non denied offer!')->error();
            return redirect()->route('public.message.home.page');
        }

        $entity->status = Discussion::AWAITING;
        $entity->save();

        flash('Offer is now awaiting!')->success();
        return redirect()->route($this->CRUDmodelName.'.edit',$entity->id);
    }

}
