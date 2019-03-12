<?php

namespace App\Notifications;

use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeApprovedNotification extends Notification
{
    use Queueable;

    protected $recipe;

    /**
     * @param Recipe $recipe
     * @return void
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
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
            'title' => trans('approves.recipe_published'),
            'message' => trans('approves.approved_' . mt_rand(1, 5), [
                'title' => $this->recipe->getTitle(),
            ]),
            'link' => '/recipes/' . $this->recipe->slug,
        ];
    }
}
