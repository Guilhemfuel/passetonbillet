<?php

namespace Tests\app\Http\Controllers\Admin\Dusk;

use App\User;
use Faker\Factory;

class UserControllerDuskTest extends BaseControllerDuskTest
{

    public function __construct()
    {
        parent::__construct();
        $this->basePath = $this->basePath . 'users';
    }

    /**
     * Test the list view isn't displayed when not admin
     */
    public function testNotAdmin()
    {
        $this->browse(function ($browser) {
            $browser->visit($this->basePath)->assertPathIs('/login');
        });
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->browse(function ($browser) {
            $this->logAsAdmin($browser);
            $browser->visit($this->basePath)->assertSee('Users');
        });
    }

    /**
     * Test the add view is displayed ok.
     */
    public function testCreateUser()
    {
        $faker = Factory::create();
        $user = new User();

        $this->browse(function ($browser) use ($faker,$user) {
            $this->logAsAdmin($browser);
            $browser->visit($this->basePath.'/create')->assertSee('Create new User');

            //Fill form
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->email;


            $browser->type('first_name',$user->first_name);
            $browser->type('last_name',$user->last_name);
            $browser->select('gender');
            $browser->select('language');
            $browser->click('[name=birthdate]');
            $browser->click('[track-by=timestamp]');
            $browser->click('[name=phone_country]');
            $browser->click('.el-select-dropdown__item');
            $browser->type('[placeholder="Phone Number"]',$faker->phoneNumber);
            $browser->type('email',$user->email);
            // Submit form
            $browser->click('[type=submit]');
            $browser->assertSee('User created');
        });

        // Make sure user is posted
        $this->assertDatabaseHas('users',$user->toArray());
    }
}
