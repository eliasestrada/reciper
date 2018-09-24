<?php

namespace App\Listeners;

use App\Events\RecipeGotDisliked;
use App\Models\User;

class RemoveExpForDislike
{
    /**
     * @param  RecipeGotDisliked  $event
     * @return void
     */
    public function handle(RecipeGotDisliked $event)
    {
        User::removeExp(0.5, $event->recipe->user_id);
    }
}
