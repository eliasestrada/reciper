<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\RecipeGotCanceled;
use App\Notifications\RecipeCanceledNotification;

class NotifyAuthorAboutCanceling
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        $author = User::whereId($event->recipe->user_id)->first();
        $author->notify(new RecipeCanceledNotification($event->recipe, $event->message));
    }
}
