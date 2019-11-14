<?php

namespace App\Mail;

use App\Models\Discussion;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotifToSellerEmail extends PtbMail
{
    use SerializesModels;
    private $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
        parent::__construct($user, $ticket);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
            ->subject(trans('email.ticket_sold_seller'))
            ->ptbMarkdown('ticket_purchased_notif_seller',
                [
                    'user' => $this->user,
                    'ticket'=> $this->ticket
                ]);
    }
}
