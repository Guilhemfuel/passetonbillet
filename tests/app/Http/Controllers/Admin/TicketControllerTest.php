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
     * Test tickets can't be created
     */
    public function testCreateTicket()
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
        $response = $this->delete( $this->basePath . '/' . $ticket->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $ticket = $ticket->fresh();
        $this->assertNull( $ticket );
    }

}
