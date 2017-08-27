<?php

namespace App\Http\Controllers\Admin;

use App\Station;
use App\Ticket;
use App\Train;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BaseController
{
    protected $CRUDmodelName = '';
    protected $CRUDsingularEntityName = '';


    public function home()
    {
        $data = [
            'ticketCount'  => Ticket::all()->count(),
            'trainCount'   => Train::all()->count(),
            'userCount'    => User::all()->count(),
            'stationCount' => Station::all()->count()
        ];

        return $this->lastarView( 'admin.dashboard', $data );
    }
}