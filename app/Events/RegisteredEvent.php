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
     * Ip used to register
     */
    public $ip;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct( $user, $source, $ip )
    {
        $this->user = $user;
        $this->source = $source;
        $this->ip = $ip;
    }
}
