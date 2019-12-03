<?php

namespace App\Notifications;

use App\Mail\FailPayoutEmail;
use App\Mail\SendFailKycEmail;
use App\Mail\SendNotifToSellerEmail;
use App\Mail\SuccessPayoutEmail;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FailPayoutNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return new FailPayoutEmail($this->user);
    }
}
