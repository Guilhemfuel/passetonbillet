<?php

namespace App\Mail;

use App\Models\Discussion;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketEmail extends PtbMail
{
    use SerializesModels;
    private $file;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Ticket $ticket
     * @param $file
     */
    public function __construct(User $user, Ticket $ticket, $file)
    {
        parent::__construct($user, $ticket);
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
            ->subject(trans('email.ticket_sold'))
            ->attach($this->file)
            ->ptbMarkdown('ticket_purchased',
                [
                    'user' => $this->user,
                    'ticket'=> $this->ticket
                ]);
    }
}
