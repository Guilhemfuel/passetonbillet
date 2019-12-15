<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Resources\Admin\TicketTableResource;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TicketController extends TableCrudController
{
    public $class = Ticket::class;
    public $classResource = TicketTableResource::class;

    /**
     * @return mixed
     */
    protected function defaultQuery() {
        $obj = ( new $this->class );

        return $obj->newQuery()->leftJoin( 'trains', 'tickets.train_id', '=', 'trains.id' )
                       ->where('trains.departure_date','>',Carbon::now()->addWeek(-1))
                       ->orderBy( 'trains.departure_date' )
                       ->select('tickets.*')
                        ->withScams();
    }

}
