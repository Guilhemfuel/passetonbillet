<?php

namespace Tests\app\Http\Controllers;

use App\Http\Resources\TicketRessource;
use App\Ticket;
use App\Station;
use App\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Tests\LastarTestCase;
use Tests\TestCase;

class TicketControllerTest extends LastarTestCase
{
    /**
     * Make sure the ajax request for tickets (given a name and booking code works)
     *
     * @return void
     */
    public function testSearchTickets()
    {
        $name = str_random( 10 );
        $code = str_random( 6 );

        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();

        \Eurostar::shouldReceive( 'retrieveTicket' )->once()
                 ->with( $name, $code )
                 ->andReturn( $tickets );

        $response = $this->beAUser()->postWithCsrf( route( 'api.tickets.search' ), [
            'last_name'    => $name,
            'booking_code' => $code
        ] );

        $this->assertEquals(
            json_decode( $response->getContent() ),
            json_decode( json_encode( [ 'data' => TicketRessource::collection( collect( $tickets ) ) ] ) ) );

        $response->assertSessionHas( 'tickets', collect( $tickets ) );
    }

    public function testSellTicketWithoutPhoneVerified(  )
    {
        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();
        $ticketIndex = random_int( 0, 1 );
        $newPrice = $tickets[ $ticketIndex ]->bought_price - random_int( 0, ( $tickets[ $ticketIndex ]->bought_price - 1 ) ); // Price between original price and 1
        $newNotes = str_random( 20 );

        $response = $this->beAUser('phone_less')->postWithCsrf( route( 'public.ticket.sell.post' ), [
            'index' => $ticketIndex,
            'price' => $newPrice,
            'notes' => $newNotes
        ], [ 'tickets' => $tickets ] );

        $response->assertStatus(302);
    }

    /**
     * Make sure than tickets can be sold
     */
    public function testSellTicket()
    {
        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();
        $ticketIndex = random_int( 0, 1 );
        $newPrice = $tickets[ $ticketIndex ]->bought_price - random_int( 0, ( $tickets[ $ticketIndex ]->bought_price - 1 ) ); // Price between original price and 1
        $newNotes = str_random( 20 );

        $response = $this->beAUser()->postWithCsrf( route( 'public.ticket.sell.post' ), [
            'index' => $ticketIndex,
            'price' => $newPrice,
            'notes' => $newNotes
        ], [ 'tickets' => $tickets ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'tickets.sell.success' );
        $flashMesage->level = 'success';

        $response->assertRedirect( route( 'home' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] )
                 ->assertSessionMissing( 'tickets' );

        // Add information to ticket to be sold
        $tickets[ $ticketIndex ]->price = $newPrice;
        $tickets[ $ticketIndex ]->currency = $tickets[ $ticketIndex ]->bought_currency;
        $tickets[ $ticketIndex ]->user_notes = $newNotes;

        $this->assertDatabaseHas( 'tickets', $tickets[ $ticketIndex ]->toArray() );
    }

    /**
     * Make sure that overpriced tickets can't be sold
     */
    public function testSellOverpricedTicket()
    {
        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();
        $ticketIndex = random_int( 0, 1 );
        $newPrice = $tickets[ $ticketIndex ]->bought_price + random_int( 1, ( $tickets[ $ticketIndex ]->bought_price ) ); //Overpriced
        $newNotes = str_random( 20 );

        $response = $this->beAUser()->postWithCsrf( route( 'public.ticket.sell.post' ), [
            'index' => $ticketIndex,
            'price' => $newPrice,
            'notes' => $newNotes
        ], [ 'tickets' => $tickets ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'tickets.sell.errors.max_value' );
        $flashMesage->level = 'danger';

        $response->assertRedirect( route( 'public.ticket.sell.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] )
                 ->assertSessionMissing( 'tickets' );

        // Add information to ticket to be sold
        $tickets[ $ticketIndex ]->price = $newPrice;
        $tickets[ $ticketIndex ]->currency = $tickets[ $ticketIndex ]->bought_currency;
        $tickets[ $ticketIndex ]->user_notes = $newNotes;

        $this->assertDatabaseMissing( 'tickets', $tickets[ $ticketIndex ]->toArray() );
    }

    /**
     * Make sure that ticket can't be sold twice
     */
    public function testSellExistingTicket()
    {
        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();
        $ticketIndex = random_int( 0, 1 );
        $newPrice = $tickets[ $ticketIndex ]->bought_price - random_int( 0, ( $tickets[ $ticketIndex ]->bought_price - 1 ) ); // Price between original price and 1
        $newNotes = str_random( 20 );

        // We create a user
        $user = factory( User::class )->create();

        // Save ticket beforehand
        $duplicateTicket = $tickets[ $ticketIndex ];
        $duplicateTicket->price = $tickets[ $ticketIndex ]->bought_price - random_int( 0, ( $tickets[ $ticketIndex ]->bought_price - 1 ) );
        $duplicateTicket->currency = $tickets[ $ticketIndex ]->bought_currency;
        $duplicateTicket->user_notes = str_random( 20 );
        $duplicateTicket->user_id = $user->id;
        $duplicateTicket->save();

        $response = $this->actingAs( $user )->postWithCsrf( route( 'public.ticket.sell.post' ), [
            'index' => $ticketIndex,
            'price' => $newPrice,
            'notes' => $newNotes
        ], [ 'tickets' => $tickets ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'tickets.sell.errors.duplicate' );
        $flashMesage->level = 'danger';

        $response->assertRedirect( route( 'public.ticket.sell.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] )
                 ->assertSessionMissing( 'tickets' );

        // Add information to ticket to be sold
        $tickets[ $ticketIndex ]->price = $newPrice;
        $tickets[ $ticketIndex ]->currency = $tickets[ $ticketIndex ]->bought_currency;
        $tickets[ $ticketIndex ]->user_notes = $newNotes;

        $this->assertDatabaseMissing( 'tickets', $tickets[ $ticketIndex ]->toArray() );
    }

    /**
     *  Make sure search to ticket available to sell works
     */
    public function testBuyTicket()
    {
        $station1 = Station::inRandomOrder()->first();
        $station2 = $station1;
        while ( $station1->id == $station2->id ) {
            $station2 = Station::inRandomOrder()->first();
        }

        $data = [
            'departure_station' => $station1->id,
            'arrival_station'   => $station2->id,
            'trip_date'         => Carbon::tomorrow()
        ];

        $response = $this->postWithCsrf( route( 'api.tickets.buy' ), $data );
        $response->assertSuccessful();
    }
}
