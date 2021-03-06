<?php

namespace App\Notifications;

use App\Mail\MessageEmail;
use App\Models\Discussion;
use App\Models\EmailSent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Facebook\Components\Button;
use NotificationChannels\Facebook\Enums\NotificationType;
use NotificationChannels\Facebook\FacebookChannel;
use NotificationChannels\Facebook\FacebookMessage;

class MessageNotification extends Notification implements ShouldQueue
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
     *
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['broadcast','database'];

        // Can't receive email notification about messages more than once per 3 min
        $class = 'App\Mail\MessageEmail';
        $count = EmailSent::where('user_id',$notifiable->id)
                          ->where('email_class', $class)
                          ->where('created_at', '>=', \Carbon\Carbon::now()->subMinutes(3))
                          ->count();

        if ($count == 0) {
            array_push($via,'mail');
        }

        return $via;

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
            'link' => route('public.message.discussion.page',[$this->discussion->ticket_id,$this->discussion->id]),
            'discussion_id' => $this->discussion->id
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'icon' => 'comment',
            'text' => __('notifications.new_message'),
            'link' => route('public.message.discussion.page',[$this->discussion->ticket_id,$this->discussion->id]),
            'discussion_id' => $this->discussion->id
        ]);
    }

    /**
     * Get the facebook messenger representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toFacebook($notifiable)
    {
        $url = route('public.message.discussion.page',[$this->discussion->ticket_id,$this->discussion->id]);

        return FacebookMessage::create()
                              ->to(['id'=>253093131783325])
                              ->text('You received a new message on PasseTonBillet.fr!')
                              ->notificationType(NotificationType::REGULAR) // Optional
                              ->buttons([
                Button::create('Reply to Message', $url)->isTypeWebUrl(),
            ]); // Buttons are optional as well.
    }
}
