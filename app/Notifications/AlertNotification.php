<?php

namespace App\Notifications;

use App\Mail\AlertEmail;
use App\Models\Alert;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $alert;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( Alert $alert )
    {
        $this->alert = $alert;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via( $notifiable )
    {
        if ($notifiable instanceof User) {
            return [ 'mail', 'broadcast' ];
        }

        return [ 'mail' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     */
    public function toMail( $notifiable )
    {
        return new AlertEmail( $this->alert, $notifiable );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toArray( $notifiable )
    {
        return [
            'icon'  => 'bell',
            'text'  => __( 'notifications.new_alert' ),
            'link'  => $this->alert->link,
            'color' => 'success'
        ];
    }
}
