<?php

namespace App\Listeners;

use App\Events\RecipeAddedToFavs;
use App\Models\User;

class AddExpForAddingToFavs
{
    /**
     * @param  RecipeAddedToFavs  $event
     * @return void
     */
    public function handle(RecipeAddedToFavs $event)
    {
        User::addExp(config('custom.exp_for_favs'), $event->recipe->user_id);
    }
}
