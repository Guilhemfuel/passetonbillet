<?php

namespace App\Mail\Verification;

use App\Mail\LastarMail;

class IdConfirmedMail extends LastarMail
{

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
                    ->subject(trans('email.id_verification_success'))
                    ->lastarMarkdown('verification.id_verification_success',
                        [
                            'user' =>$this->user
                        ]);
    }
}
