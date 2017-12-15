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
        $response->assertRedirect( route( 'home' ) );

        // Crypt password
        $userData['password'] = bcrypt( 'password' );

        $this->assertDatabaseHas( 'users', [ 'email' => $userData['email'] ] );
        Event::assertDispatched( RegisteredEvent::class, function ( $e ) use ( $userData ) {
            return $e->user->email === $userData['email'];
        } );

    }

    /**
     * Gives data supposed to fail to create a new user
     */
    public function registerFailDataProvider()
    {

        $firstNameMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $firstNameMissing['first_name'] );
        $lastNameMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $lastNameMissing['last_name'] );
        $languageMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $languageMissing['language'] );
        $phoneCountryMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $phoneCountryMissing['phone_country'] );
        $phoneMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $phoneMissing['phone'] );
        $emailMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $emailMissing['email'] );
        $passwordMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $passwordMissing['password_confirmation'] );

        $allMissing = factory( User::class )->states( 'not_registered' )->make()->toArray();
        unset( $allMissing['first_name'] );
        unset( $allMissing['last_name'] );
        unset( $allMissing['language'] );
        unset( $allMissing['phone_country'] );
        unset( $allMissing['phone'] );
        unset( $allMissing['email'] );
        unset( $allMissing['password'] );

        return [
            'first_name missing'    => [ $firstNameMissing ],
            'last_name missing'     => [ $lastNameMissing ],
            'email missing'         => [ $emailMissing ],
            'password missing'      => [ $passwordMissing ],
            'All missing'           => [ $allMissing ],
        ];
    }

    /**
     * Make sure registration fails when it needs to
     * @dataProvider registerFailDataProvider
     */
    public function testFailRegister( $userData )
    {
        Event::fake();

        // Set a password to user
        $userData['password'] = 'password';

        $response = $this->postWithCsrf( route( 'register' ), $userData );
        $response->assertSessionHasErrors();

        if ( isset( $userData['email'] ) ) {
            $this->assertDatabaseMissing( 'users', [ 'email' => $userData['email'] ] );
        }
        Event::assertNotDispatched( RegisteredEvent::class );
    }

    /**
     * Test that the verify link works for a user
     */
    public function testVerify()
    {
        $unconfirmedUser = factory( User::class )->states( 'not_confirmed' )->create();

        $this->get(route('register.verify-email',['token'=>$unconfirmedUser->email_token]))
        ->assertRedirect(route('home'));

        $unconfirmedUser = $unconfirmedUser->fresh();
        $this->assertTrue($unconfirmedUser->email_verified);
        $this->assertEquals(1,$unconfirmedUser->status);
        $this->assertNull($unconfirmedUser->email_token);
    }

    /**
     * Test random string doesn't verify user
     */
    public function testFailVerify()
    {
        $unconfirmedUser = factory( User::class )->states( 'not_confirmed' )->create();

        $this->get(route('register.verify-email',['token'=>str_random(40)]))
             ->assertRedirect(route('home'));

        $unconfirmedUser = $unconfirmedUser->fresh();
        $this->assertFalse($unconfirmedUser->email_verified);
        $this->assertEquals(0,$unconfirmedUser->status);
        $this->assertNotNull($unconfirmedUser->email_token);
    }


}
