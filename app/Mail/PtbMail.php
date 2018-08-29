<?php

namespace App\Mail;

use App\Models\EmailSent;
use App\Ticket;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Mail\Mailer as MailerContract;

abstract class PtbMail extends Mailable
{
    const DESCRIPTION = 'La description n\'est pas définie!';

    public $user, $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket = null)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }

    /**
     * Override send function to store email
     */
    public function send(MailerContract $mailer)
    {
        // Email is normally sent
        parent::send($mailer);

        // We store the fact that it was sent
        foreach ($this->to as $recipient){
            $user = User::where('email',$recipient['address'])->first();
            if (!$user) continue;

            $emailSent = new EmailSent(['user_id'=>$user->id,
                                        'ticket_id'=>$this->ticket?$this->ticket->id:null,
                                        'email_class'=>get_class($this)
            ]);
            $emailSent->save();
        }
    }

    /**
     * Depending on user's language send the translated email
     */
    public function ptbMarkdown($view,$data=[]){
        if(strtolower( $this->user->language ) == 'fr'){
            $view = 'emails.fr.'.$view;
        } else {
            $view = 'emails.en.'.$view;
        }

        return $this->markdown($view,$data);
    }
}
