<?php

namespace Tests\App;

use App\Http\Resources\TicketRessource;
use App\Ticket;
use App\Train;
use App\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Tests\PtbTestCase;
use Tests\TestCase;

class TicketTest extends PtbTestCase
{

    /** Make sure that apply filter function can return nothing */
    public function testApplyFilterNoResults()
    {
        $ticket = factory( Ticket::class )->make();

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date );

        $this->assertEquals( 0, count( $retrievedTickets ) );
    }

    /**
     * Make sure the apply filters functionnality workds properly
     */
    public function testApplyFiltersOneTicket()
    {
        $ticket = factory( Ticket::class )->create();
        $ticketDate = new \DateTime();

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date , null, true);

        $this->assertEquals( 1, count( $retrievedTickets ) );
        $this->assertEquals( $ticket->id, $retrievedTickets->first()->id );
    }

    /**
     * Make sure the apply filters functionnality works properly for severals tickets on same train
     */
    public function testApplyFiltersMultipleTicketsSameTrain()
    {
        $ticket = factory( Ticket::class )->create();
        $ticket2 = factory( Ticket::class )->create( [
            'train_id' => $ticket->train_id
        ] );
        $ticket3 = factory( Ticket::class )->create( [
            'train_id' => $ticket->train_id
        ] );


        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date  , null, true);

        $this->assertEquals( 3, count( $retrievedTickets ) );

        // Make sure all tickets were found
        $ticketList = [ $ticket->id, $ticket2->id, $ticket3->id ];
        foreach ( $retrievedTickets as $retrievedTicket ) {
            $this->assertTrue( in_array( $retrievedTicket->id, $ticketList ) );
        }
    }

    /**
     * Make sure the apply filters functionnality works properly for several tickets on different trains
     */
    public function testApplyFiltersMultipleTicketsDifferentTrains()
    {
        $train = factory( Train::class )->create();
        $train2 = factory( Train::class )->create( [
            'departure_date' => $train->departure_date,
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
        ] );
        $train3 = factory( Train::class )->create( [
            'departure_date' => $train->departure_date,
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
        ] );

        $ticket = factory( Ticket::class )->create( [
            'train_id' => $train->id
        ] );
        $ticket2 = factory( Ticket::class )->create( [
            'train_id' => $train2->id
        ] );
        $ticket3 = factory( Ticket::class )->create( [
            'train_id' => $train3->id
        ] );

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date );

        $this->assertEquals( 3, count( $retrievedTickets ) );
        // Make sure all tickets were found
        $ticketList = [ $ticket->id, $ticket2->id, $ticket3->id ];
        foreach ( $retrievedTickets as $retrievedTicket ) {
            $this->assertTrue( in_array( $retrievedTicket->id, $ticketList ) );
        }
    }

    /**
     * Make sure the apply filters functionnality works properly for several tickets on same day
     */
    public function testApplyFiltersMultipleTicketsSameDay()
    {
        $train = factory( Train::class )->create();
        $train2 = factory( Train::class )->create( [
            'departure_date' => $train->departure_date,
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
        ] );

        $ticket = factory( Ticket::class )->create( [
            'train_id' => $train->id
        ] );
        $ticket2 = factory( Ticket::class )->create( [
            'train_id' => $train->id
        ] );
        $ticket3 = factory( Ticket::class )->create( [
            'train_id' => $train2->id
        ] );
        $ticket4 = factory( Ticket::class )->create( [
            'train_id' => $train2->id
        ] );

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date );

        $this->assertEquals( 4, count( $retrievedTickets ) );
        // Make sure all tickets were found
        $ticketList = [ $ticket->id, $ticket2->id, $ticket3->id, $ticket4->id ];
        foreach ( $retrievedTickets as $retrievedTicket ) {
            $this->assertTrue( in_array( $retrievedTicket->id, $ticketList ) );
        }
    }

    /**
     * Make sure ticket with wrong destination or wrong date are ignored
     */
    public function testApplyFiltersIgnoreSomeTickets()
    {
        $train = factory( Train::class )->create( [
                'departure_date' => Carbon::today()
            ]
        );
        $train2 = factory( Train::class )->create( [
            'departure_date' => Carbon::today(),
            'departure_city' => $train->arrival_city,
            'arrival_city'   => $train->departure_city,
        ] );
        $train3 = factory( Train::class )->create( [
            'departure_date' => Carbon::tomorrow(),
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
        ] );

        $ticket = factory( Ticket::class )->create( [
            'train_id' => $train->id
        ] );
        $ticket2 = factory( Ticket::class )->create( [
            'train_id' => $train2->id
        ] );
        $ticket3 = factory( Ticket::class )->create( [
            'train_id' => $train3->id
        ] );

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date  , null, true);

        $this->assertEquals( 1, count( $retrievedTickets ) );
        $this->assertEquals( $ticket->id, $retrievedTickets->first()->id );
    }

    public function testApplyFiltersWithTime(  )
    {
        $train = factory( Train::class )->create([
            'departure_time' => '10:00'
        ]);
        $train2 = factory( Train::class )->create( [
            'departure_time' => '12:00',
            'departure_date' => $train->departure_date,
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
        ] );

        $ticket = factory( Ticket::class )->create( [
            'train_id' => $train->id
        ] );
        $ticket2 = factory( Ticket::class )->create( [
            'train_id' => $train2->id
        ] );

        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date );

        // Make sure all tickets were found
        $this->assertEquals( 2, count( $retrievedTickets ) );
        $ticketList = [ $ticket->id, $ticket2->id];
        foreach ( $retrievedTickets as $retrievedTicket ) {
            $this->assertTrue( in_array( $retrievedTicket->id, $ticketList ) );
        }

        // Make sure only secund ticket is found
        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date,
            '11:00'  , true);
        $this->assertEquals( 1, count( $retrievedTickets ) );
        $this->assertEquals( $ticket2->id, $retrievedTickets->first()->id );

        // Make sure no tickets are found
        $retrievedTickets = Ticket::applyFilters(
            $ticket->train->departure_city,
            $ticket->train->arrival_city,
            $ticket->train->departure_date,
            '13:00', true);
        $this->assertEquals( 0, count( $retrievedTickets ) );

    }

}
