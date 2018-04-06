<?php

namespace App\Notifications;

use App\Mail\AcceptedOfferEmail;
use App\Mail\OfferEmail;
use App\Mail\TicketSoldEmail;
use App\Models\Discussion;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SoldToYouNotification extends Notification implements ShouldQueue
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
     * @return TicketSoldEmail
     */
    public function toMail($notifiable)
    {
        return new TicketSoldEmail( $notifiable, $this->discussion );
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
            'text' => __('notifications.ticket_sold'),
            'link' => route('public.ticket.owned.page',['tab'=>'bought']),
            'discussion_id' => $this->discussion->id,
            'color'=> 'success'
        ];
    }
}
