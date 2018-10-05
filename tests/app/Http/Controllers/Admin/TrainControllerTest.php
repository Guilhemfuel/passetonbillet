<?php

namespace Tests\app\Http\Controllers\Admin;

use App\Train;
use Faker\Factory;


class TrainControllerTest extends BaseControllerTest
{

    public function setUp()
    {
        parent::setUp();

        $this->basePath = $this->basePath . 'trains';
        $this->beAnAdmin();

        // Create some trains
        factory( Train::class , 10)->create();
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

        $response = $this->json('POST', $this->basePath, $trainArray );

        $insertedTrain = Train::orderBy( 'id', 'DESC' )->first();

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $insertedTrain->id . '/edit' );

        // Train datetime is converted to time only, to keep it simple we just don't search
        unset($trainArray['arrival_time']);
        unset($trainArray['departure_time']);

        // Check few values
        $this->assertEquals($insertedTrain->number,$trainArray['number']);
        $this->assertEquals($insertedTrain->departure_date->format('d/m/Y'),$trainArray['departure_date']);
        $this->assertEquals($insertedTrain->arrival_date->format('d/m/Y'),$trainArray['arrival_date']);

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
        $response = $this->deleteWithCsrf( $this->basePath . '/' . $train->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $train = $train->fresh();
        $this->assertNotNull( $train->deleted_at );
    }

    // Controller expect arrival time and departure time to be datetime when receiving request
    // It then converts them to time
    private function postableTrain(Train $train)
    {
        $faker = Factory::create();

        $trainArray = $train->toArray();
        $trainArray['departure_date'] = $train->departure_date->format('d/m/Y');
        $trainArray['arrival_date'] = $train->arrival_date->format('d/m/Y');

        $trainArray['arrival_time'] = $faker->dateTimeThisMonth()->format('H:i:s');
        $trainArray['departure_time'] =  $faker->dateTimeThisMonth()->format('H:i:s');

        return $trainArray;
    }
}
