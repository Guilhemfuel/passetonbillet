<?php


namespace App\Mail;

use App\Models\Discussion;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewRequestEmail extends PtbMail
{
    use SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Discussion $discussion )
    {
        parent::__construct($user,$discussion->ticket);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
                    ->subject(trans('email.review_request'))
                    ->ptbMarkdown('review_request',
                        [
                            'user' => $this->user
                        ]);
    }
}

