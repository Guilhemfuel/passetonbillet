<?php

namespace App\Notifications;

use App\Mail\MailResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return new MailResetPassword( $notifiable, $this->token );
    }
}
