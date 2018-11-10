<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// class ResetPasswordNotification extends Notification implements ShouldQueue
class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @codeCoverageIgnore
     * @param string $token
     * @param User $user
     * @return void
     */
    public function __construct(string $token, User $user)
    {
        $this->token = $token;
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
     * @codeCoverageIgnore
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('password/reset', $this->token);
        $get_param = urlencode($this->user->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject(trans('passwords.reset_pwd'))
            ->view('emails.reset-password', [
                'token' => $this->token,
                'user' => $this->user,
                'url' => "{$url}?email={$get_param}",
            ]);
    }
}
