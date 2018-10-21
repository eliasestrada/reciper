<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;

class NotifyAuthorAboutApproving
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        $author = User::whereId($event->recipe->user_id)->first();
        $author->notify(new RecipeApprovedNotification($event->recipe));
    }
}
