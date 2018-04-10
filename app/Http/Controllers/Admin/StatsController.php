<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AppHelper;
use App\Models\Statistic;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth.admin' );
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

        $data = [
            'dailyUserCount' => \AppHelper::dailyCreatedStat(User::class),
            'dailyTicketCount' => \AppHelper::dailyCreatedStat(Ticket::class),
            'dailyResearchCount' => \AppHelper::dailyCreatedStat(Statistic::class,function($query){
                return $query->where('action','search_tickets');
            }),
            'dailyPdfDownloadCount' => \AppHelper::dailyCreatedStat(Statistic::class,function($query){
                return $query->where('action','download_pdf');
            })
        ];

        return view( 'admin.unique.stats.index', $data );
    }
}
