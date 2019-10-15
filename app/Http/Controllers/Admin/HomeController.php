<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alert;
use App\Models\Discussion;
use App\Models\Review;
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
        return $this->ptbView( 'admin.dashboard' );
    }

    /**
     * Log page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logs()
    {
        return view( 'admin.unique.logs.index', [
            'logs' => Statistic::latest()->limit( 200 )->get()
        ] );
    }

    /**
     * Review page
     */
    public function reviews()
    {
        return view( 'admin.unique.reviews.index', [
            'reviews' => Review::latest()->get()
        ] );
    }
}
