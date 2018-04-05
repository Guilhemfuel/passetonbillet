<?php

namespace Tests\app\Http\Controllers;

use App\Http\Resources\TicketRessource;
use App\Notifications\OfferNotification;
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

    public function testSellTicketWithoutPhoneVerified()
    {
        $tickets = factory( Ticket::class, 2 )->states( 'new' )->make();
        $ticketIndex = random_int( 0, 1 );
        $newPrice = $tickets[ $ticketIndex ]->bought_price - random_int( 0, ( $tickets[ $ticketIndex ]->bought_price - 1 ) ); // Price between original price and 1
        $newNotes = str_random( 20 );

        $response = $this->beAUser( 'phone_less' )->postWithCsrf( route( 'public.ticket.sell.post' ), [
            'index' => $ticketIndex,
            'price' => $newPrice,
            'notes' => $newNotes
        ], [ 'tickets' => $tickets ] );

        $response->assertStatus( 302 );
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

        $response->assertRedirect( route( 'public.ticket.owned.page' ) )
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

    /**
     * Make sure you can make an offer to a ticket
     */
    public function testMakeAnOffer()
    {
        \Notification::fake();

        $ticket = factory( Ticket::class )->create();
        $buyer = factory( User::class )->create();
        $price = rand( 1, $ticket->price );

        $this->be( $buyer );
        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $price,
            'ticket_id' => $ticket->id
        ] );

        $response->assertSuccessful();
        $this->assertDatabaseHas( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'price'     => $price,
            'status'    => 0
        ] );

        \Notification::assertSentTo(
            $ticket->user,
            OfferNotification::class,
            function ( $notification ) use ( $ticket ) {
                return $notification->discussion->ticket->id === $ticket->id;
            }
        );

    }

    /**
     * Make sure you can't make an offer without price or ticket id
     */
    public function testMakeAnOfferWithMissingFields()
    {
        \Notification::fake();

        $ticket = factory( Ticket::class )->create();
        $buyer = factory( User::class )->create();
        $price = rand( 1, $ticket->price );

        $this->be( $buyer );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price' => $price,
        ] );
        $response->assertStatus( 302 );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'ticket_id' => $ticket->id,
        ] );
        $response->assertStatus( 302 );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ) );
        $response->assertStatus( 302 );

        $this->assertDatabaseMissing( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'price'     => $price,
            'status'    => 0
        ] );

        \Notification::assertNotSentTo(
            [ $buyer ], OfferNotification::class
        );
    }

    public function testMakeAnOfferTicketNotFound()
    {
        \Notification::fake();

        $buyer = factory( User::class )->create();
        $price = rand( 1, 100 );

        // Find a random ticket and delete it (to make sure id is wrong)
        $ticket = factory( Ticket::class )->create();
        $ticket_id = $ticket->id;
        $ticket->delete();

        $this->be( $buyer );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $price,
            'ticket_id' => $ticket_id
        ] );
        $response->assertStatus( 500 );

        $this->assertDatabaseMissing( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'price'     => $price,
            'status'    => 0
        ] );

        \Notification::assertNotSentTo(
            [ $buyer ], OfferNotification::class
        );
    }

    public function testMakeAnOfferWrongPrice()
    {
        \Notification::fake();

        $ticket = factory( Ticket::class )->create();
        $buyer = factory( User::class )->create();

        $this->be( $buyer );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => 0,
            'ticket_id' => $ticket->id
        ] );
        $response->assertStatus( 500 );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $ticket->price + 1,
            'ticket_id' => $ticket->id
        ] );
        $response->assertStatus( 500 );

        $this->assertDatabaseMissing( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'status'    => 0
        ] );

        \Notification::assertNotSentTo(
            [ $buyer ], OfferNotification::class
        );
    }

    /**
     * Make sure you can't make an offer to one of your tickets
     */
    public function testMakeAnOfferForOwnTicket()
    {
        \Notification::fake();

        $ticket = factory( Ticket::class )->create();
        $buyer = $ticket->user;
        $price = rand( 1, $ticket->price );

        $this->be( $buyer );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $price,
            'ticket_id' => $ticket->id
        ] );
        $response->assertStatus( 500 );

        $this->assertDatabaseMissing( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'price'     => $price,
            'status'    => 0
        ] );

        \Notification::assertNotSentTo(
            [ $buyer ], OfferNotification::class
        );
    }

    /**
     * Make sure you can't make an offer twice for the same ticket
     */
    public function testMakeAnOfferTwice()
    {
        \Notification::fake();

        $ticket = factory( Ticket::class )->create();
        $buyer = factory( User::class )->create();
        $price = rand( 1, $ticket->price );

        $this->be( $buyer );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $price,
            'ticket_id' => $ticket->id
        ] );
        $response->assertSuccessful();
        $this->assertDatabaseHas( 'discussions', [
            'ticket_id' => $ticket->id,
            'buyer_id'  => $buyer->id,
            'price'     => $price,
            'status'    => 0
        ] );

        \Notification::assertSentTo(
            $ticket->user,
            OfferNotification::class,
            function ( $notification ) use ( $ticket ) {
                return $notification->discussion->ticket->id === $ticket->id;
            }
        );

        $response = $this->postWithCsrf( route( 'api.tickets.offer' ), [
            'price'     => $price,
            'ticket_id' => $ticket->id
        ] );
        $response->assertStatus( 500 );
    }

    /**
     * Make sure a ticket owner can delete a ticket not sold yet
     */
    public function testDeleteTicket()
    {
        $ticket = factory( Ticket::class )->create();
        $this->be( $ticket->user );
        $reponse = $this->deleteWithCsrf( route( 'public.ticket.delete' ), [
            'ticket_id' => $ticket->id
        ] );
        $reponse->assertRedirect( route( 'public.ticket.owned.page' ) );
        $this->assertDatabaseMissing( 'tickets', [
            'id'         => $ticket->id,
            'deleted_at' => null
        ] );
    }

    /**
     * Make sure ticket deletion fails when needed
     */
    public function testFailDeleteFakeTicket()
    {
        // First we make sure that if ticket isn't found it fails
        $ticket = factory( Ticket::class )->create();
        $ticket_id = $ticket->id;
        $user = $ticket->user;
        $ticket->delete();

        $this->be( $user );
        $response = $this->deleteWithCsrf( route( 'public.ticket.delete' ), [
            'ticket_id' => $ticket->id
        ] );
        $response->assertRedirect( route( 'public.ticket.owned.page' ) );
        $this->assertResponseHasFlashMsg( $response, 'danger', __( 'common.error' ), true );
    }

    public function testFailDeleteSoldTicket()
    {
        // Now we make sure that a sold ticket can't be deleted
        $user = factory( User::class )->create();
        $ticket = factory( Ticket::class )->create( [
            'sold_to_id' => $user->id,
        ] );
        $this->be( $ticket->user );
        $response = $this->deleteWithCsrf( route( 'public.ticket.delete' ), [
            'ticket_id' => $ticket->id
        ] );
        $response->assertRedirect( route( 'public.ticket.owned.page' ) );
        $this->assertResponseHasFlashMsg( $response, 'danger', __( 'common.error' ), true );
    }

    public function testFailDeleteStrangersTicket()
    {
        // Now we make sure that only the owner of the ticket can delete a ticket
        $user = factory( User::class )->create();
        $this->be( $user );
        $ticket = factory( Ticket::class )->create();
        $response = $this->deleteWithCsrf( route( 'public.ticket.delete' ), [
            'ticket_id' => $ticket->id
        ] );
        $response->assertRedirect( route( 'public.ticket.owned.page' ) );
        $this->assertResponseHasFlashMsg( $response, 'danger', __( 'common.error' ), true );
    }
}
