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

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Ticket $ticket
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
        $name = 'PTB Ticket n°' . $this->ticket->id . ' - ' . $this->ticket->train->departureCity->name . '-' . $this->ticket->train->arrivalCity->name . '.pdf';

        return $this->to($this->user->email,$this->user->full_name)
            ->subject(trans('email.ticket_sold'))
            ->attachFromStorageDisk('s3', env('STORAGE_PDF') . '/' . $this->ticket->pdf, $name)
            ->ptbMarkdown('ticket_purchased',
                [
                    'user' => $this->user,
                    'ticket'=> $this->ticket
                ]);
    }
}
