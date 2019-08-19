<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends PtbMail
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
                   ->subject(trans('email.welcome',[],$this->getLocale()))
                   ->ptbMarkdown('welcome',
                       [
                           'user' =>$this->user,
                       ]);
    }
}
