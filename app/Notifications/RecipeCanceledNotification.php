<?php

namespace App\Notifications;

use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeCanceledNotification extends Notification
{
    use Queueable;

    public $recipe;
    public $message;

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
            'title' => trans('notifications.recipe_not_published'),
            'message' => $this->message,
            'recipe_id' => $this->recipe->id,
        ];
    }
}
