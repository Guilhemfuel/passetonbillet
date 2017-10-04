<?php

namespace Tests\app\Http\Controllers\Admin;

use Faker\Factory;
use App\Station;

class StationControllerTest extends BaseControllerTest
{

    public function setUp()
    {
        parent::setUp();

        $this->basePath = $this->basePath . 'stations';
        $this->beAnAdmin();
    }

    /**
     * Data provider to test that all views are displayed without errors
     */
    public function urlDataProvider()
    {
        $this->setUp();

        $station = Station::inRandomOrder()->first();

        return [
            'Admin Station Home'   => [ '/', 'Stations' ],
            'Admin Create Station' => [ '/create', 'Create new Station' ],
            'Admin Edit Station'   => [ '/' . $station->id . '/edit', 'Edit Station' ],
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
     * Test stations can be created
     */
    public function testCreateStation()
    {
        $station = factory( Station::class )->make();

        // Create station
        $response = $this->post( $this->basePath, $this->postableStation($station) );

        $insertedId = Station::orderBy( 'id', 'DESC' )->first()->id;

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $insertedId . '/edit' );

        $this->assertDatabaseHas( 'stations',$this->postableStation($station) );
    }

    /**
     * Test Station can be edited
     */
    public function testUpdateStation()
    {
        $station = factory( Station::class )->make();
        $station->save();
        $newStationData = factory( Station::class )->make();

        // Update Station
        $response = $this->put( $this->basePath . '/' . $station->id, $this->postableStation($newStationData) );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $station->id . '/edit' );

        // Make sure Station is updated with proper data
        $station = $station->fresh();
        $this->assertArraySubset( $this->postableStation($newStationData), $station->toArray() );

    }

    /**
     * Test station can be deleted
     */
    public function testDeleteStation()
    {
        $station = factory( Station::class )->make();
        $station->save();

        // Delete station
        $response = $this->deleteWithCsrf( $this->basePath . '/' . $station->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $station = $station->fresh();
        $this->assertNotNull( $station->deleted_at );
    }

    // At the moment timezone isn't in form
    private function postableStation(Station $station)
    {
        $stationArray = $station->toArray();
        unset($stationArray['timezone_txt']);
        unset($stationArray['timezone']);

        return $stationArray;
    }

}
