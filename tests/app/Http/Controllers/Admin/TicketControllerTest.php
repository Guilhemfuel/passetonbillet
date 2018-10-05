<?php

namespace Tests\app\Http\Controllers\Admin;

use Faker\Factory;
use App\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketControllerTest extends BaseControllerTest
{

    public function setUp(  )
    {
        parent::setUp();
        $this->beAnAdmin();

        $this->basePath = $this->basePath . 'tickets';

        // Create some tickets
        factory( Ticket::class , 10)->create();

    }

    /**
     *  Test views work
     */
    public function testViews( )
    {

        $ticket = Ticket::inRandomOrder()->first();

        $tests = [
              '/' => 'Tickets' ,
             '/' . $ticket->id . '/edit' =>  'Edit Ticket',
        ];

        foreach ($tests as $url => $toSee) {
            $this->get( $this->basePath . $url )->assertSuccessful()->assertSee( $toSee );
        }
    }

    /**
     * Test can't create a ticket
     */
    public function testCreateTicket()
    {
        factory( Ticket::class , 10)->create();

        // Create fake ticket
        $ticketCount = Ticket::all()->count();

        $response = $this->beAnAdmin()->get(route('tickets.create') );

        $response->assertRedirect( route('tickets.index'));

        // No tickets were created
        $this->assertEquals($ticketCount ,Ticket::all()->count() );
    }


    /**
     * Test can't store a ticket
     */
    public function testStoreTicket()
    {
        $ticket = factory( Ticket::class )->make();

        // Create tickets
        $response = $this->post( $this->basePath, $ticket->toArray() );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );


        $this->assertDatabaseMissing( 'tickets',$ticket->toArray() );
    }

    /**
     * Test Ticket can be edited
     */
    public function testUpdateTicket()
    {
        $ticket = factory( Ticket::class )->create();
        $newTicketData = factory( Ticket::class )->make();

        // Update Ticket
        $response = $this->put( $this->basePath . '/' . $ticket->id, $newTicketData->toArray() );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $ticket->id . '/edit' );

        // Make sure ticket is updated with proper data
        $ticket = $ticket->fresh();
        $this->assertArraySubset( $newTicketData->toArray(), $ticket->toArray() );

    }

    /**
     * Test ticket can be deleted
     */
    public function testDeleteTicket()
    {
        $ticket = factory( Ticket::class )->make();
        $ticket->save();

        // Delete ticket
        $response = $this->deleteWithCsrf( $this->basePath . '/' . $ticket->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $ticket = $ticket->fresh();
        $this->assertNotNull( $ticket->deleted_at );
    }

    /**
     * Test Ticket can be edited
     */
    public function testMarkTicketAsScam()
    {
        $ticket = factory( Ticket::class )->create([
            'marked_as_fraud_at' => null
        ]);

        // Mark as scan Ticket
        $this->get( route('tickets.edit',$ticket->id) );
        $response = $this->get( route('tickets.scam',$ticket->id) );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $ticket->id . '/edit' );

        // Make sure ticket is updated with proper data
        $ticket = $ticket->fresh();
        $this->assertTrue( $ticket->scam );

    }

}
