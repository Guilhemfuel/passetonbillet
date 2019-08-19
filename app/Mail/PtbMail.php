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

    protected $forcedLocale = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( User $user = null, Ticket $ticket = null )
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
        return $this->view( 'view.name' );
    }

    /**
     * Override send function to store email
     */
    public function send( MailerContract $mailer )
    {
        // Email is normally sent
        parent::send( $mailer );

        // We store the fact that it was sent
        foreach ( $this->to as $recipient ) {
            $user = User::where( 'email', $recipient['address'] )->first();
            if ( ! $user ) {
                continue;
            }

            $emailSent = new EmailSent( [
                'user_id'     => $user->id,
                'ticket_id'   => $this->ticket ? $this->ticket->id : null,
                'email_class' => get_class( $this )
            ] );
            $emailSent->save();
        }
    }

    /**
     * Depending on user's language send the translated email
     */
    public function ptbMarkdown( $view, $data = [] )
    {
        $lang = $this->getLocale();

        if ( $lang == 'en' ) {
            $view = 'emails.en.' . $view;
        } else {
            $view = 'emails.fr.' . $view;
        }

        return $this->markdown( $view, $data );
    }

    /**
     * Return locale to use in emails.
     *
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getLocale(  )
    {
        // Return forced locale if defined.
        if ($this->forcedLocale != null) {
            return $this->forcedLocale;
        }

        if ($this->user instanceof User && $this->user->language ) {
            $locale = strtolower( $this->user->language );
        } else {
            $locale = config('app.fallback_locale');
        }

        return $locale;
    }

    /**
     * Used mostly for debugging purposes. Forces the locale to be used.
     */
    public function forceLocale( $locale )
    {
        $locale = strtolower($locale);

        if (! in_array($locale, array_keys( config('app.locales')))) {
            throw new \Exception('Locale '.$locale. ' undefined.');
        }

        $this->forcedLocale = $locale;
    }
}
