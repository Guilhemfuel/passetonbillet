<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AppHelper;
use App\Models\Alert;
use App\Models\Discussion;
use App\Models\Statistic;
use App\Ticket;
use App\Train;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth.admin' );
    }

    private function currentTickets()
    {
        // Get current ticket count
        $currentTrains = Train::where( function ( $query ) {
            $query->where( 'departure_time', '>=', Carbon::now()->addHours( 2 )->toTimeString() )
                  ->where( 'departure_date', Carbon::now() );
        } )
                              ->orWhere( 'departure_date', '>', Carbon::now() )
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

        return $currentTickets;
    }

    /**
     * Show a list of all stats
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $currentTickets = $this->currentTickets();
        $ticketGrowth = $this->getTicketGrowth();

        $segmentations = [
            'sncf'     => $currentTickets->where( 'provider', 'sncf' )->count(),
            'eurostar' => $currentTickets->where( 'provider', 'eurostar' )->count(),
            'thalys'   => $currentTickets->where( 'provider', 'thalys' )->count(),
            'ouigo'   => $currentTickets->where( 'provider', 'ouigo' )->count(),
            'izy'   => $currentTickets->where( 'provider', 'izy' )->count(),
        ];

        $data = [
            'dailyTicketSoldCount'  => \AppHelper::dailyCreatedStat( Discussion::class, function ( $query ) {
                return $query->where( 'status', Discussion::SOLD );
            }, 'updated_at' ),
            'dailyUserCount'        => \AppHelper::dailyCreatedStat( User::class ),
            'dailyTicketCount'      => \AppHelper::dailyCreatedStat( Ticket::class ),
            'dailyOfferCount'       => \AppHelper::dailyCreatedStat( Discussion::class ),
            'dailyAlertCount'       => \AppHelper::dailyCreatedStat( Alert::class ),
            'dailyResearchCount'    => \AppHelper::dailyCreatedStat( Statistic::class, function ( $query ) {
                return $query->where( 'action', 'search_tickets' );
            } ),
            'dailyPdfDownloadCount' => \AppHelper::dailyCreatedStat( Statistic::class, function ( $query ) {
                return $query->where( 'action', 'download_pdf' );
            } ),
            'ticketSegmentation' => $segmentations,
            'ticketGrowth' => $ticketGrowth
        ];

        return view( 'admin.unique.stats.index', [ 'datasets' => $data ] );
    }

    /**
     * Get stats for current ticket growth
     */
    private function getTicketGrowth() {
        $aMonthAgo = Carbon::now()->subMonth();
        $stats = Statistic::where('created_at','>',$aMonthAgo)
            ->where('action',Statistic::TICKET_COUNT_DAILY)
            ->get();

        $data = [];
        foreach ($stats as $stat) {
            $tempData = json_decode( $stat->data );
            $statData = 0;
            if (isset($tempData->current_tickets_count)) {
                $statData = $tempData->current_tickets_count;
            }

            $data[$stat->created_at->format( 'Y-m-d' )] = $statData;
        }

        ksort($data);

        return $data;
    }
}
