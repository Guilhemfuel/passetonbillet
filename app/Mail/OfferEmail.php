<?php

namespace App\Mail;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferEmail extends PtbMail
{
    use SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email,$this->user->full_name)
                    ->subject(trans('email.offer',[],$this->getLocale()))
                    ->ptbMarkdown('offer',
                        [
                            'user' =>$this->user,
                            'ticket'=>$this->ticket
                        ]);
    }
}
