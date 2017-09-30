<?php

namespace App\Mail;

use App\Models\EmailSent;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer as MailerContract;

abstract class LastarMail extends Mailable
{
    use Queueable, SerializesModels;

    const DESCRIPTION = 'La description n\'est pas définie!';

    public $user, $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    abstract public function __construct(User $user, Ticket $ticket = null);

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
}
