<?php

namespace App\Notifications\Verification;

use App\Mail\Verification\IdConfirmedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return new IdConfirmedMail( $notifiable );
    }

    public function toArray($notifiable)
    {
        return [
            'icon' => 'check-circle',
            'text' => __('notifications.verification.id.success'),
            'link' => route('public.profile.home')
        ];
    }
}
