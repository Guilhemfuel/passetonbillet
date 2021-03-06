<?php

namespace App\Events\Admin;

use App\Models\Verification\IdVerification;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class IdAccepted
 * @package App\Events\Admin
 *
 * Triggered when an admin accepts an id.
 *
 */
class IdAcceptedEvent
{
    public $idVerification;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(IdVerification $idVerification)
    {
        $this->idVerification = $idVerification;
    }

}
