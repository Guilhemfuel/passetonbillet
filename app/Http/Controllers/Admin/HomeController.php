<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discussion;
use App\Models\Statistic;
use App\Models\Verification\IdVerification;
use App\Station;
use App\Ticket;
use App\Train;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BaseController
{
    protected $CRUDmodelName = '';
    protected $CRUDsingularEntityName = '';


    public function home()
    {
        // Get current ticket count
        $currentTrains = Train::where(function($query){
                            $query->where('departure_time', '>=', Carbon::now()->addHours(2)->toTimeString() )
                                  ->where('departure_date', Carbon::now());
                        })
                        ->orWhere('departure_date','>', Carbon::now())
                        ->with( 'tickets' )->get();

        $currentTickets = collect();
        foreach ( $currentTrains as $train ) {
            if ( $train->tickets()->withoutScams() ) {
                foreach ( $train->tickets as $ticket ) {
                    if ( $ticket->sold_to_id == null ) {
                        $currentTickets->push( $ticket );
                    }
                }
            }
        }

        $data = [
            'ticketCount'         => Ticket::all()->count(),
            'currentTicketCount'  => $currentTickets->count(),
            'ticketSoldCount'     => Ticket::whereNotNull('sold_to_id')->count(),
            'trainCount'      => Train::all()->count(),
            'userCount'           => User::all()->count(),
            'stationCount'        => Station::all()->count(),
            'idVerificationCount' => IdVerification::awaitingCount(),
            'offerCount'          => Discussion::all()->count()
        ];

        return $this->ptbView( 'admin.dashboard', $data );
    }

    public function logs()
    {
        return view('admin.unique.logs.index',[
           'logs' => Statistic::latest()->limit(200)->get()
        ]);
    }
}
