<?php

namespace Tests\app\Http\Controllers;

use App\Helper\ImageHelper;
use App\Http\Resources\TicketRessource;
use App\Models\Verification\PhoneVerification;
use App\Notifications\Verification\IdConfirmed;
use App\Notifications\Verification\IdDenied;
use App\Ticket;
use App\Station;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Nexmo\Laravel\Facade\Nexmo;
use Nexmo\Message\Client;
use Tests\PtbTestCase;
use Tests\TestCase;

class UserControllerTest extends PtbTestCase
{

    // Make sure user can upload id
    public function testUploadId()
    {
        $user = factory( User::class )->create();
        $fakeUrl = 'http://fakeurl.com/test.jpg';

        \App\Facades\ImageHelper::shouldReceive( 'resizeImageAndUploadToS3' )->once()->andReturn( $fakeUrl );

        $this->be($user);
        $response = $this->postWithCsrf( route( 'public.profile.id.upload' ), [
            'scan'         => UploadedFile::fake()->image('id.jpg')
        ] );

        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'profile.modal.verify_identity.success' );
        $flashMesage->level = 'success';

        $response->assertRedirect(route('public.profile.home'))
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );

        $user = $user->fresh();
        $this->assertEquals($user->idVerification->scan,\Storage::disk('s3')->temporaryUrl(ltrim('test.jpg', '/'),now()->addMinutes(5)));
    }

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

    // Make sure you can change your password
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

        $this->assertTrue(\Hash::check( $newPassword, $user->password));

    }

    public function testChangeProfilePicture()
    {
        $user = factory( User::class )->create();
        $fakeUrl = 'http://fakeurl.com';

        \App\Facades\ImageHelper::shouldReceive( 'fitImageAndUploadToS3' )->once()->andReturn( $fakeUrl );

        $this->be($user);
        $response = $this->postWithCsrf( route( 'public.profile.picture.upload' ), [
            'picture'         => UploadedFile::fake()->image('avatar.jpg')
        ] );


        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = false;
        $flashMesage->message = __( 'profile.modal.change_picture.success' );
        $flashMesage->level = 'success';

        $response->assertRedirect()
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );

        $user = $user->fresh();
        $this->assertEquals($user->picture,$fakeUrl);
    }

    // Adding a phone number that another user has should not work
    public function testAddPhoneWithUsedNumber()
    {
        $userData = factory( User::class )->create();
        $user = factory( User::class )->states('phone_less')->create();

        $this->be($user);
        $response = $this->postWithCsrf( route( 'public.profile.phone.add' ), [
            'phone'         => $userData->phone,
            'phone_country' => $userData->phone_country
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

    /**
     * Assert that a notif received is equal to a notif retrieved in db
     *
     * @param $received
     * @param $dbRetrieved
     */
    private function assertReceivedNotificationEqual($received,$dbRetrieved){
        $this->assertEquals( (array) $received,(array) $dbRetrieved->data);
    }

    /**
     * Provde an array of all notifications to be tested
     * @return array
     */
    public function notificationsProvider(){
        return [
            [IdConfirmed::class,null],
            [IdDenied::class,str_random(30)]
        ];
    }

    /**
     * @dataProvider notificationsProvider
     */
    public function testGetNotifications($notificationClass,$argument1){
        \Mail::fake();

        $user = factory( User::class )->create();
        if ($argument1){
            $user->notify(new $notificationClass($argument1));
        } else {
            $user->notify(new $notificationClass());
        }
        
        $this->assertEquals(1,count($user->unreadNotifications));

        $this->be($user);

        $unreadNotifications = $user->unreadNotifications;
        $response = $this->get(route('api.notifications'));

        $notificationsReceived = \GuzzleHttp\json_decode( $response->getContent() );

        $user = $user->fresh();
        $this->assertEquals(0,count($user->unreadNotifications));
        $this->assertReceivedNotificationEqual( $notificationsReceived[0],$unreadNotifications->first());
    }

}
