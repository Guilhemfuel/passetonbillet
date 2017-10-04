<?php

namespace Tests\app\Http\Controllers\Auth;

use Illuminate\Support\Facades\Event;
use App\Events\RegisteredEvent;
use App\User;
use Tests\LastarTestCase;

class RegisterControllerTest extends LastarTestCase
{

    /**
     * Data provider to test that all views are displayed without errors
     */
    public function urlDataProvider()
    {
        $this->setUp();

        return [
            'Register' => [ route( 'register.page' ), 'Register' ],
            'Login'    => [ route( 'login.page' ), 'Login' ],
        ];
    }

    /**
     * @dataProvider urlDataProvider
     */
    public function testViews( $url, $toSee )
    {
        $this->get( $url )->assertSuccessful()->assertSee( $toSee );
    }

    /**
     * Gives data supposed to work to create a new user
     */
    public function registerDataProvider()
    {

        $birthdayMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $birthdayMissing['birthdate'] );
        $genderMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $birthdayMissing['gender'] );
        $locationMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $locationMissing['location'] );

        $allMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $allMissing['location'] );
        unset( $allMissing['gender'] );
        unset( $allMissing['birthdate'] );

        return [
            'Form fully filled' => [ factory( User::class )->states( 'not_registered' )->make()->toArray() ],
            'Birthdate missing' => [ $birthdayMissing ],
            'Gender missing'    => [ $genderMissing ],
            'Location missing'  => [ $locationMissing ],
            'All missing'       => [ $allMissing ],

        ];
    }

    /**
     * Make sure that register function works properly
     * @dataProvider registerDataProvider
     */
    public function testRegister( $userData )
    {

        Event::fake();

        // Set a password to user
        $userData['password'] = 'password';

        $response = $this->postWithCsrf( route( 'register' ), $userData );
        print_r($response->getContent());
        $response->assertRedirect( route( 'home' ) );

        // Crypt password
        $userData['password'] = bcrypt( 'password' );

        $this->assertDatabaseHas( 'users', [ 'email' => $userData['email'] ] );
        Event::assertDispatched( RegisteredEvent::class, function ( $e ) use ( $userData ) {
            return $e->user->email === $userData['email'];
        } );

    }


}
