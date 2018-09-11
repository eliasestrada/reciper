<?php

namespace App\Listeners;

use App\Events\RecipeGotDrafted;
use App\Models\User;

class RemovePointsForDrafting
{
    /**
     * @param  RecipeGotDrafted  $event
     * @return void
     */
    public function handle(RecipeGotDrafted $event)
    {
        User::removePoints(1, $event->recipe->user_id);
    }
}
