<?php

namespace Tests\app\Http\Controllers\Admin;

use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Train;

class TrainControllerTest extends BaseControllerTest
{

    public function setUp()
    {
        parent::setUp();

        $this->basePath = $this->basePath . 'trains';
        $this->beAnAdmin();
    }

    /**
     * Data provider to test that all views are displayed without errors
     */
    public function urlDataProvider()
    {
        $this->setUp();

        $train = Train::inRandomOrder()->first();

        return [
            'Admin Train Home'   => [ '/', 'Trains' ],
            'Admin Create Train' => [ '/create', 'Create new Train' ],
            'Admin Edit Train'   => [ '/' . $train->id . '/edit', 'Edit Train' ],
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
     * Test trains can be created
     */
    public function testCreateTrain()
    {
        $train = factory( Train::class )->make();

        // Create train
        $trainArray = $this->postableTrain($train);
        $response = $this->post( $this->basePath, $trainArray );

        $insertedId = Train::orderBy( 'id', 'DESC' )->first()->id;

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $insertedId . '/edit' );

        // Train datetime is converted to time only, to keep it simple we just don't search time
        unset($trainArray['arrival_time']);
        unset($trainArray['departure_time']);

        $this->assertDatabaseHas( 'trains', $trainArray );
    }

    /**
     * Test train can be edited
     */
    public function testUpdateTain()
    {
        $train = factory( Train::class )->make();
        $train->save();
        $newTrainData = factory( Train::class )->make();

        // Update train
        $response = $this->put( $this->basePath . '/' . $train->id, $newTrainData->toArray() );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $train->id . '/edit' );

        // Make sure train is updated with proper data
        $train = $train->fresh();
        $this->assertArraySubset( $newTrainData->toArray(), $train->toArray() );

    }

    /**
     * Test train can be deleted
     */
    public function testDeleteTrain()
    {
        $train = factory( Train::class )->make();
        $train->save();

        // Delete train
        $response = $this->delete( $this->basePath . '/' . $train->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $train = $train->fresh();
        $this->assertNull( $train );
    }

    // Controller expect arrival time and departure time to be datetime when receiving request
    // It then converts them to time
    private function postableTrain(Train $train)
    {
        $faker = Factory::create();

        $trainArray = $train->toArray();
        $trainArray['arrival_time'] = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
        $trainArray['departure_time'] =  $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');

        return $trainArray;
    }
}
