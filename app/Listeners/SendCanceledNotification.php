<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;
use App\Models\Notification;

class SendCanceledNotification
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        LNotification::sendToUser(
            trans('notifications.recipe_not_published'),
            $event->message,
            $event->recipe->user_id
        );
    }
}
