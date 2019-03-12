<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\User;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @codeCoverageIgnore
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
        return (new MailMessage)
            ->subject(trans('messages.email_confirmation'))
            ->markdown('emails.email-verification', [
                'token' => action('Invokes\VerifyEmailController', [
                    'token' => $this->user->token,
                ]),
            ]);
    }
}
