<?php

namespace Tests\app\Http\Controllers\Admin;

use App\User;

class UserControllerTest extends BaseControllerTest
{

    public function setUp()
    {
        parent::setUp();

        $this->basePath = $this->basePath . 'users';
        $this->beAnAdmin();
    }

    /**
     * Data provider to test that all views are displayed without errors
     */
    public function urlDataProvider()
    {
        $this->setUp();

        $user = User::inRandomOrder()->first();

        return [
            'Admin User Home'   => [ '/', 'Users' ],
            'Admin Create User' => [ '/create', 'Create new User' ],
            'Admin Edit User'   => [ '/' . $user->id . '/edit', 'Edit User' ],
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
     * Test user can be created
     */
    public function testCreateUser()
    {
        $userArray = factory( User::class )->states('not_registered')->make()->toArray();
        $userArray['password'] = 'password';

        // Create user
        $response = $this->postWithCsrf( $this->basePath, $userArray );

        $insertedId = User::orderBy( 'id', 'DESC' )->first()->id;

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $insertedId . '/edit' );

        unset($userArray['password'],$userArray['password_confirmation']);

        $this->assertDatabaseHas( 'users', $userArray );
    }

    /**
     * Test user can be edited
     */
    public function testUpdateUser()
    {
        $user = factory( User::class )->create();
        $newUserData = factory( User::class )->make();

        // Update user
        $response = $this->putWithCsrf( $this->basePath . '/' . $user->id, $newUserData->toArray() );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $user->id . '/edit' );

        // Make sure user is updated with proper data
        $user = $user->fresh();
        $this->assertArraySubset( $newUserData->toArray(), $user->toArray() );

    }

    /**
     * Test user can be deleted
     */
    public function testDeleteUser()
    {
        $user = factory( User::class )->make();
        $user->save();

        // Delete user
        $response = $this->deleteWithCsrf( $this->basePath . '/' . $user->id );

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath );

        $user = $user->fresh();
        $this->assertNotNull( $user->deleted_at );
    }


    /* -------------------------------------
       ----------------API------------------
       ------------------------------------- */

    /**
     * Make sure Api return proper result
     *
     * @dataProvider searchApiDataProvider
     *
     */
    public function testSearchApi($search, $expectedCount)
    {
        $response = $this->get(route('api.users.search',['name'=>$search]));
        $content = \GuzzleHttp\json_decode($response->getContent());
        $this->assertEquals($expectedCount,count($content),print_r($content));
    }

    /**
     * Provide search and expected results
     */
    public function searchApiDataProvider()
    {
        $this->setUp();

        $user1 = User::inRandomOrder()->first();
        $user2 = User::inRandomOrder()->skip( 1 )->first();

        $nullString = str_random( 5 );
        while ( User::search( $nullString )->count() > 0 ) {
            $nullString = str_random( 5 );
        }

        return [
            'First User by firstname'  => [
                $user1->first_name,
                min( User::search( $user1->first_name )->count(), 10  )
            ],
            'First User by lastname'   => [
                $user1->last_name,
                min( User::search( $user1->last_name )->count(), 10  )
            ],
            'Secund User by firstname' => [
                $user2->first_name,
                min( User::search( $user2->first_name )->count(), 10  )
            ],
            'Secund User by lastname'  => [
                $user2->last_name,
                min( User::search( $user2->last_name )->count(), 10 )
            ],
            'No user corresponding'    => [
                $nullString,
                0
            ]
        ];

    }
}
