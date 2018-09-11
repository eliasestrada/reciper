<?php

namespace App\Listeners;

use App\Events\RecipeIsApproved;
use App\Models\User;

class AddPointsForRecipe
{
    /**
     * @param  RecipeIsApproved  $event
     * @return void
     */
    public function handle(RecipeIsApproved $event)
    {
        user()->addPoints(1.0, $event->recipe->user_id);
    }
}
