<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;

class SendHappyNotificationToAuthor
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        User::whereId($event->user_id)->first()->notify(new RecipeApprovedNotification($event->recipe));
    }
}
