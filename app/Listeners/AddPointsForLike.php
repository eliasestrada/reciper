<?php

namespace App\Listeners;

use App\Events\RecipeGotLiked;
use App\Models\User;

class AddPointsForLike
{
    /**
     * @param  RecipeGotLiked  $event
     * @return void
     */
    public function handle(RecipeGotLiked $event)
    {
        User:addPoints(0.5, $event->recipe->user_id);
    }
}
