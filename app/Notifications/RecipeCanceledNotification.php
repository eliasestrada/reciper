<?php

namespace App\Notifications;

use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeCanceledNotification extends Notification
{
    use Queueable;

    protected $recipe;
    protected $message;

    /**
     * @param Recipe $recipe
     * @param string $message
     * @return void
     */
    public function __construct(Recipe $recipe, string $message)
    {
        $this->recipe = $recipe;
        $this->message = $message;
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
            'title' => trans('approves.recipe_not_published'),
            'message' => $this->message,
            'link' => '/recipes/' . $this->recipe->slug,
        ];
    }
}
