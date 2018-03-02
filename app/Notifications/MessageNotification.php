<?php

namespace App\Notifications;

use App\Mail\MessageEmail;
use App\Models\EmailSent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $discussion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($discussion)
    {
        $this->discussion = $discussion;
    }

    /**quit
     *
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Can't receive email notification about messages more than once per hour
        $class = 'App\Mail\MessageEmail';
        $count = EmailSent::where('user_id',$notifiable->id)
                          ->where('email_class', $class)
                          ->where('created_at', '>=', \Carbon\Carbon::now()->subHour())
                          ->count();

        if ($count == 0) {
            return ['mail','database'];
        } else {
            return ['database'];
        }

    }

    /**
     * Get the mail representation of the notification.
     *
     * We don't notify users about messages more than once per hour
     */
    public function toMail($notifiable)
    {
        return new MessageEmail( $notifiable, $this->discussion->ticket, $this->discussion );
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
            'icon' => 'comment',
            'text' => __('notifications.new_message'),
            'link' => route('public.message.discussion.page',[$this->discussion->ticket_id,$this->discussion->id])
        ];
    }
}
