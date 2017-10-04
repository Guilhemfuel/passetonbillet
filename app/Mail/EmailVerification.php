<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends LastarMail
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('email.account_activation'))
                    ->lastarMarkdown('email_verification',
                        [
                            'user' =>$this->user
                        ]);
    }
}
