<?php

namespace App\Mail\Verification;

use App\Mail\PtbMail;

class IdConfirmedMail extends PtbMail
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
                    ->ptbMarkdown('verification.id_verification_success',
                        [
                            'user' =>$this->user
                        ]);
    }
}
