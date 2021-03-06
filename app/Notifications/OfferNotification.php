<?php

namespace App\Notifications;

use App\Mail\OfferEmail;
use App\Models\Discussion;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $discussion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return OfferEmail
     */
    public function toMail($notifiable)
    {
        return new OfferEmail( $notifiable, $this->discussion->ticket );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'ticket',
            'text' => __('notifications.offer'),
            'link' => route('public.message.home.page'),
            'discussion_id' => $this->discussion->id
        ];
    }
}
