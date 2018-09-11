<?php

namespace App\Listeners;

use App\Events\RecipeGotViewed;
use App\Models\User;

class AddPointsForView
{
    /**
     * @param  RecipeGotViewed  $event
     * @return void
     */
    public function handle(RecipeGotViewed $event)
    {
        User:addPoints(0.1, $event->recipe->user_id);
    }
}
