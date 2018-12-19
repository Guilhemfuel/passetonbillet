<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;

class RegisteredEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Source of register.
     */
    public $source;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct( $user, $source )
    {
        $this->user = $user;
        $this->source = $source;
    }
}
