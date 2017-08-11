<?php

namespace Tests\Feature\app\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserController;
use Tests\BaseControllerTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends BaseControllerTest
{

    public function __construct()
    {
        parent::__construct();

        $this->basePath = $this->basePath . 'users';
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->browse(function ($browser) {
            $this->logAsAdmin($browser);

            $browser->visit($this->basePath);
            $value = $browser->value('User');
            echo $value;
        });
    }
}
