<?php

namespace App\Mail;

class MailResetPassword extends PtbMail
{
    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        parent::__construct($user, null);
        $this->token = $token;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
                    ->subject(trans('email.password_reset'))
                    ->ptbMarkdown('password_reset',
                        [
                            'user' => $this->user,
                            'token' => $this->token
                        ]);
    }
}
