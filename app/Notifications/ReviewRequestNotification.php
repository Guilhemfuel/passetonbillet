<?php

namespace App\Notifications;

use App\Mail\ReviewRequestEmail;
use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewRequestNotification extends Notification implements ShouldQueue
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
     * @return ReviewRequestEmail;
     */
    public function toMail($notifiable)
    {
        return new ReviewRequestEmail($this->discussion->buyer, $this->discussion);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $discussion_id = $this->discussion->id;
        $ticket_id = $this->discussion->ticket_id;
        return [
            'text' => __('email.review_request'),
            'discussion_id' => $discussion_id,
            'ticket_id' => $ticket_id,
            'link' => route('tickets.edit', ['ticket_id' => $ticket_id]),
            'color'=> 'success'
        ];
    }
}
