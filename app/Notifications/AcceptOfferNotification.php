<?php

namespace App\Notifications;

use App\Mail\AcceptedOfferEmail;
use App\Mail\OfferEmail;
use App\Models\Discussion;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptOfferNotification extends Notification implements ShouldQueue
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
     * @return AcceptedOfferEmail
     */
    public function toMail($notifiable)
    {
        return new AcceptedOfferEmail( $notifiable, $this->discussion );
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
            'icon' => 'check-circle',
            'text' => __('notifications.offer_accepted'),
            'link' => route('public.message.discussion.page',[
                $this->discussion->ticket->id,
                $this->discussion->id
            ]),
            'discussion_id' => $this->discussion->id,
            'color'=> 'success'
        ];
    }
}
