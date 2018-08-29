<?php

namespace App\Mail;

use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorEmail extends Mailable implements ShouldQueue
{
    use SerializesModels, Queueable;

    public $ticket, $title;

    public function __construct( $ticket, $title )
    {
        $this->ticket = $ticket;
        $this->title = $title;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('mail.from.address'),'Ptb')
                    ->subject('Erreur Ptb: '.$this->title)
                    ->markdown('emails.error',
                        [
                            'ticket' =>$this->ticket,
                        ]);
    }
}
