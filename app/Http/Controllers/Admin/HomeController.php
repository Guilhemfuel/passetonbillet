<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discussion;
use App\Models\Verification\IdVerification;
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
            'ticketCount'         => Ticket::all()->count(),
            'ticketSoldCount'     => Ticket::whereNotNull('sold_to_id')->count(),
                'trainCount'      => Train::all()->count(),
            'userCount'           => User::all()->count(),
            'stationCount'        => Station::all()->count(),
            'idVerificationCount' => IdVerification::awaitingCount(),
            'offerCount'          => Discussion::all()->count()
        ];

        return $this->ptbView( 'admin.dashboard', $data );
    }
}
