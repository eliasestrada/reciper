<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserGotXpPoints extends Notification
{
    use Queueable;

    /**
     * @var int $points
     */
    protected $points;

    /**
     * @param int $points
     * @return void
     */
    public function __construct(int $points)
    {
        $this->points = $points;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @codeCoverageIgnore
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message' => trans('notifications.you_got_points', [
                'points' => $this->points,
            ]),
        ];
    }
}
