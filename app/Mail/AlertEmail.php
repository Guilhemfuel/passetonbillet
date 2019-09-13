<?php

namespace App\Mail;

use App\Models\Alert;
use App\Train;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertEmail extends PtbMail
{
    use Queueable, SerializesModels;

    public $alert, $train, $user, $email;

    public function __construct( Alert $alert, Train $train, $user)
    {
        $this->alert = $alert;
        $this->train = $train;

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
                            'alert' => $this->alert,
                            'train' => $this->train,
                            'link' => $this->alert->getLink($this->train->carbon_departure_date)
                        ]);
    }
}
