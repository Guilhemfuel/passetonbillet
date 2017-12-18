<?php

namespace Tests\app\Http\Controllers;

use App\Http\Resources\TicketRessource;
use App\Models\Verification\PhoneVerification;
use App\Ticket;
use App\Station;
use App\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Nexmo\Laravel\Facade\Nexmo;
use Nexmo\Message\Client;
use Tests\LastarTestCase;
use Tests\TestCase;

class UserControllerTest extends LastarTestCase
{

    // Make sure that you can't change a password if you give a false password for the actual one
    public function testChangePasswordWrongOldPassword()
    {
        $user = factory( User::class )->create();
        $actualPassword = str_random(8);
        $newPassword = str_random(8);

        $user->password = \Hash::make($actualPassword);
        $user->save();

        $this->be($user);
        $response = $this->postWithCsrf( route( 'public.profile.password.change' ), [
            'old_password'  => str_random(8),
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'profile.modal.change_password.flash.wrong_old_password' );
        $flashMesage->level = 'danger';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );

    }

    // Make sur you can change your password
    public function testChangePassword()
    {
        $user = factory( User::class )->create();
        $actualPassword = str_random(8);
        $newPassword = str_random(8);

        $user->password = \Hash::make($actualPassword);
        $user->save();

        $this->be($user);
        $response = $this->postWithCsrf( route( 'public.profile.password.change' ), [
            'old_password'  => $actualPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'profile.modal.change_password.flash.success' );
        $flashMesage->level = 'success';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );

    }

    // Adding a phone number that another user has should not work
    public function testAddPhoneWithUsedNumber()
    {
        $user = factory( User::class )->create();

        $response = $this->beAUser( 'phone_less' )->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $user->phone,
            'phone_country' => $user->phone_country
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'tickets.sell.confirm_number.errors.phone_already_used' );
        $flashMesage->level = 'danger';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    // Adding a phone number if user already has one shouldn't work
    public function testAddPhoneWithAlreadyAPhone()
    {
        $user = factory( User::class )->make();

        $response = $this->beAUser()->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $user->phone,
            'phone_country' => $user->phone_country
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'tickets.sell.confirm_number.errors.phone_already_verified' );
        $flashMesage->level = 'danger';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    // Adding a phone number if a user already tried to add a number 3 times shouldn't work
    public function testAddPhoneMoreThan3Times()
    {
        $user = factory( User::class )->states( 'phone_less' )->create();
        $userData = factory( User::class )->make();

        for ( $i = 0; $i < 3; $i ++ ) {
            $phoneVerification = new PhoneVerification( [
                'user_id' => $user->id,
                'phone'   => $userData->phone,
                'phone_country'   => $userData->phone_country,
            ] );
            $phoneVerification->save();
            $phoneVerification->delete();
        }

        $this->be( $user );
        $response = $this->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $userData->phone,
            'phone_country' => $userData->phone_country
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __('tickets.sell.confirm_number.errors.verify_max_retry');
        $flashMesage->level = 'danger';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    // Make sure that both phone and phone country are required
    public function testAddPhoneWithMissingInfo(  )
    {
        // Without phone country
        $userData = factory( User::class )->make();
        $response = $this->beAUser()->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $userData->phone
        ] );

        $response->assertRedirect();
        $this->assertDatabaseMissing('phone_verifications', [
            'user_id' => \Auth::user()->id,
            'phone' => $userData->phone,
        ]);

        // Without phone
        $response = $this->beAUser()->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone_country' => $userData->phone_country
        ] );

        $response->assertRedirect();
        $this->assertDatabaseMissing('phone_verifications', [
            'user_id' => \Auth::user()->id,
            'phone_country' => $userData->phone_country
        ]);

        // With nothing
        $response = $this->beAUser()->postWithCsrf( route( 'public.profile.phone.add' ), [] );

        $response->assertRedirect();
        $this->assertDatabaseMissing('phone_verifications', [
            'user_id' => \Auth::user()->id,
        ]);

    }

    public function testAddPhone(  )
    {
        $userData = factory( User::class )->make();

        $response = $this->beAUser('phone_less')->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $userData->phone,
            'phone_country' => $userData->phone_country
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __('tickets.sell.confirm_number.success.code_sent');
        $flashMesage->level = 'success';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );

        $this->assertDatabaseHas('phone_verifications', [
            'user_id' => \Auth::user()->id,
            'phone' => $userData->phone,
            'phone_country' => $userData->phone_country,
        ]);
    }

}
