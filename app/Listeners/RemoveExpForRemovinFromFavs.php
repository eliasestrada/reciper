<?php

namespace App\Listeners;

use App\Events\RecipeRemovedFromFavs;
use App\Models\User;

class RemoveExpForRemovinFromFavs
{
    /**
     * @param  RecipeRemovedFromFavs  $event
     * @return void
     */
    public function handle(RecipeRemovedFromFavs $event)
    {
        User::removeExp(config('custom.exp_for_favs'), $event->recipe->user_id);
    }
}
