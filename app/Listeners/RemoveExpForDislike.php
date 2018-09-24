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
        User::removeExp(config('custom.exp_for_like'), $event->recipe->user_id);
    }
}
