<?php

namespace App\Listeners;

use App\Events\RecipeGotDisliked;
use App\Models\User;

class RemovePointsForDislike
{
    /**
     * @param  RecipeGotDisliked  $event
     * @return void
     */
    public function handle(RecipeGotDisliked $event)
    {
        User::removePoints(0.5, $event->recipe->user_id);
    }
}
