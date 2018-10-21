<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;

class NotifyAuthorAboutCanceling
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        $author = User::whereId($event->recipe->user_id)->first();
        $author->notify(new RecipeApprovedNotification($event->recipe, $event->message));
    }
}
