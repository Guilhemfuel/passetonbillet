<?php

namespace App\Mail\Verification;

use App\Mail\LastarMail;

class IdDeniedMail extends LastarMail
{

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $comment )
    {
        parent::__construct( $user, null );
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to( $this->user->email, $this->user->full_name )
                    ->subject( trans( 'email.id_verification_fail' ) )
                    ->lastarMarkdown( 'verification.id_verification_fail',
                        [
                            'user' => $this->user,
                            'comment' => $this->comment
                        ] );
    }
}
