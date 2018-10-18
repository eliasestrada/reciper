<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;
use App\Notifications\RecipeApprovedNotification;

class SendCanceledNotification
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        user()->notify(new RecipeApprovedNotification($event->recipe, $event->message));
    }
}
