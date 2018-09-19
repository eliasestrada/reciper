<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\Notification;

class SendApprovedNotification
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        Notification::sendToUser(
            trans('notifications.recipe_published'),
            $event->message,
            $event->recipe->getTitle(),
            $event->recipe->user_id
        );
    }
}
