<?php

namespace Tests\app\Http\Controllers\Admin;

use Faker\Factory;
use App\Ticket;

class TicketControllerTest extends BaseControllerTest
{

    public function setUp()
    {
        parent::setUp();

        $this->basePath = $this->basePath . 'tickets';
        $this->beAnAdmin();
    }

    /**
     * Data provider to test that all views are displayed without errors
     */
    public function urlDataProvider()
    {
        $this->setUp();

        $station = Ticket::inRandomOrder()->first();

        // Ticket can't be created
        return [
            'Admin Ticket Home'   => [ '/', 'Tickets' ],
            'Admin Edit Ticket'   => [ '/' . $station->id . '/edit', 'Edit Ticket' ],
        ];
    }

    /**
     * @dataProvider urlDataProvider
     */
    public function testViews( $url, $toSee )
    {
        $this->get( $this->basePath . $url )->assertSuccessful()->assertSee( $toSee );
    }

    /**
     * Test create a fake ticket
     */
    public function testCreateTicket()
    {
        // Create fake ticket
        $ticketCount = Ticket::all()->count();
        $this->beAnAdmin();
        $response = $this->get(route('tickets.create') );
        $ticket = Ticket::orderByDesc('created_at')->first();

        $response->assertRedirect( route('tickets.edit',$ticket->id ));

        $this->assertEquals($ticketCount + 1,Ticket::all()->count() );
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
        $response->assertRedirect( $this->basePath.'.index' );


        $this->assertDatabaseMissing( 'tickets',$ticket->toArray() );
    }

    /**
     * Test Ticket can be edited
     */
    public function testUpdateTicket()
    {
        $ticket = factory( Ticket::class )->make();
        $ticket->save();
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
