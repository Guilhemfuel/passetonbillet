<?php

namespace Tests\app\Http\Controllers\Admin;

use App\Models\Verification\IdVerification;
use App\Notifications\Verification\IdConfirmed;
use App\Notifications\Verification\IdDenied;
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
        $userArray = factory( User::class )->states( 'not_registered' )->make()->toArray();
        $userArray['password'] = 'password';

        // Create user
        $response = $this->postWithCsrf( $this->basePath, $userArray );

        $insertedId = User::orderBy( 'id', 'DESC' )->first()->id;

        $response->assertStatus( 302 );
        $response->assertRedirect( $this->basePath . '/' . $insertedId . '/edit' );

        unset( $userArray['password'], $userArray['password_confirmation'] );

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

    /**
     * Test id verification acceptance work
     */
    public function testAcceptIdVerification()
    {
        \Notification::fake();

        $user = factory( User::class )->create();

        $idVerif = new IdVerification( [
            'user_id' => $user->id,
            'scan'    => 'http://test.img'
        ] );

        $idVerif->save();

        $response = $this->beAnAdmin()->postWithCsrf( route( 'id_check.accept' ), [
            'verification_id' => $idVerif->id
        ] );

        \Notification::assertSentTo(
            $user,
            IdConfirmed::class
        );

        $this->assertDatabaseHas( 'id_verifications', [
            'user_id'  => $user->id,
            'accepted' => true,
            'id'       => $idVerif->id,
            'scan'     => 'http://test.img'
        ] );

        $response->assertRedirect( route( 'id_check.oldest' ) );
    }

    /**
     * Test id verification acceptance fails with already accepted id
     */
    public function testAcceptIdVerificationAlreadyHandled()
    {
        \Notification::fake();

        $user = factory( User::class )->create();

        $idVerif = new IdVerification( [
            'user_id' => $user->id,
            'scan'    => 'http://test.img'
        ] );
        $idVerif->save();
        $idVerif->accepted = true;
        $idVerif->save();

        $response = $this->beAnAdmin()->postWithCsrf( route( 'id_check.accept' ), [
            'verification_id' => $idVerif->id
        ] );

        \Notification::assertNotSentTo(
            $user, IdConfirmed::class
        );

        $response->assertRedirect( route( 'id_check.oldest' ) );
    }

    /**
     * Test id verification acceptance work
     */
    public function testDenyIdVerification()
    {
        \Notification::fake();

        $user = factory( User::class )->create();

        $idVerif = new IdVerification( [
            'user_id' => $user->id,
            'scan'    => 'http://test.img'
        ] );

        $comment = str_random( 26 );

        $idVerif->save();

        $response = $this->beAnAdmin()->postWithCsrf( route( 'id_check.deny' ), [
            'verification_id' => $idVerif->id,
            'comment'         => $comment
        ] );

        \Notification::assertSentTo(
            $user,
            IdDenied::class,
            function ( $notification ) use ( $comment ) {
                return $notification->comment === $comment;
            }

        );

        $this->assertSoftDeleted( 'id_verifications', [
            'user_id'  => $user->id,
            'accepted' => false,
            'id'       => $idVerif->id,
            'scan'     => 'http://test.img',
            'comment'  => $comment
        ] );

        $response->assertRedirect( route( 'id_check.oldest' ) );
    }

    /**
     * Test id verification denying fails with already accepted id
     */
    public function testDenyIdVerificationAlreadyHandled()
    {
        \Notification::fake();

        $user = factory( User::class )->create();

        $idVerif = new IdVerification( [
            'user_id' => $user->id,
            'scan'    => 'http://test.img'
        ] );
        $idVerif->save();
        $idVerif->accepted = true;
        $idVerif->save();

        $response = $this->beAnAdmin()->postWithCsrf( route( 'id_check.deny' ), [
            'verification_id' => $idVerif->id,
            'comment'         => str_random( 20 )
        ] );

        \Notification::assertNotSentTo(
            $user, IdDenied::class
        );

        $response->assertRedirect( route( 'id_check.oldest' ) );
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
    public function testSearchApi( $search, $expectedCount )
    {
        $response = $this->get( route( 'api.users.search', [ 'name' => $search ] ) );
        $content = \GuzzleHttp\json_decode( $response->getContent() );
        $this->assertEquals( $expectedCount, count( $content ), print_r( $content ) );
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
                min( User::search( $user1->first_name )->count(), 10 )
            ],
            'First User by lastname'   => [
                $user1->last_name,
                min( User::search( $user1->last_name )->count(), 10 )
            ],
            'Secund User by firstname' => [
                $user2->first_name,
                min( User::search( $user2->first_name )->count(), 10 )
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

    /**
     * Make sure regular users can't impersonate
     */
    public function testImpersonateUsersNonAdmin()
    {
        $user = factory( User::class )->create();
        $userToImpersonate = factory( 'App\User' )->create();
        $this->be($user);
        $this->get( route( 'users.impersonate', $userToImpersonate ) )
             ->assertStatus( 302 );
        $this->assertNotEquals( auth()->id(), $userToImpersonate->id );

    }

    /**
     * Make sure regular users can't impersonate
     */
    public function testImpersonateUsers()
    {
        $user = factory( User::class )->create();
        $this->get( route( 'users.impersonate', $user ) );
        $this->assertEquals( auth()->id(), $user->id );
    }
}
