<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class RegisteredEvent extends \Illuminate\Auth\Events\Registered
{

    use SerializesModels;

}
