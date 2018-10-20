<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;

class SendSadNotificationToAuthor
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        User::whereId($event->user_id)->first()->notify(new RecipeApprovedNotification($event->recipe, $event->message));
    }
}
