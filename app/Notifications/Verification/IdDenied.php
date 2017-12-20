<?php

namespace App\Notifications\Verification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Mail\Verification\IdDeniedMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdDenied extends Notification implements ShouldQueue
{
    use Queueable;

    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return IdDeniedMail
     */
    public function toMail($notifiable)
    {
        return new IdDeniedMail( $notifiable, $this->comment );

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
            'icon' => 'times',
            'text' => __('notifications.verification.id.failure'),
            'link' => route('public.profile.home')
        ];
    }
}
