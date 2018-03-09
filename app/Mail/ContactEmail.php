<?php

namespace App\Mail;

use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable implements ShouldQueue
{
    use SerializesModels, Queueable;

    public $name, $email, $message;

    public function __construct( $name, $email, $message )
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('mail.from.address'),'Lastar')
                    ->subject('Contact Lastar: '.$this->name)
                    ->markdown('emails.contact',
                        [
                            'name' =>$this->name,
                            'email'=>$this->email,
                            'message'=>$this->message
                        ]);
    }
}
