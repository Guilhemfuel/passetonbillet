<?php

namespace App\Notifications;

use App\Mail\SendTicketEmail;
use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendTicketNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $user;
    private $ticket;
    private $file;

    public function __construct(User $user, Ticket $ticket, $file)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->file = $file;
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
        return new SendTicketEmail($this->user, $this->ticket, $this->file);
    }
}
