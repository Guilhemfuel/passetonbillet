<?php

namespace App\Mail;

use App\Models\Alert;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertEmail extends PtbMail
{
    use Queueable, SerializesModels;

    public $alert, $user, $email;

    public function __construct( Alert $alert, $user)
    {
        $this->alert = $alert;

        if ($user instanceof User ) {
            parent::__construct( $user, null);
            $this->email = $user->email;
        } else {
            $this->email = $user->routes['mail'];
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->user instanceof User && $this->user->language ) {
            $locale = strtolower( $this->user->language );
        } else {
            $locale = config('app.fallback_locale');
        }

        return $this->to($this->email)
                    ->subject(__('email.alert_triggered',[], $locale))
                    ->ptbMarkdown('alert_triggered',
                        [
                            'user' => $this->user,
                            'alert' => $this->alert
                        ]);
    }
}
