<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\User;

class AddPointsForRecipe
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        User::addPoints(5, $event->recipe->user_id);
    }
}
