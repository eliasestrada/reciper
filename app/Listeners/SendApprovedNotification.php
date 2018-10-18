<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Notifications\RecipeApprovedNotification;

class SendApprovedNotification
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        user()->notify(new RecipeApprovedNotification($event->recipe));
    }
}
