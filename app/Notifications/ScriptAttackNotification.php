<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScriptAttackNotification extends Notification
{
    use Queueable;

    public $username;

    /**
     * @param string $username
     * @return void
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => trans('notifications.title_script_attack'),
            'message' => trans('notifications.message_script_attack', ['username' => $this->username]),
            'link' => '/users/' . $this->username,
        ];
    }
}
