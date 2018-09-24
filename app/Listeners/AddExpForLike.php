<?php

namespace App\Listeners;

use App\Events\RecipeGotLiked;
use App\Models\User;

class AddExpForLike
{
    /**
     * @param  RecipeGotLiked  $event
     * @return void
     */
    public function handle(RecipeGotLiked $event)
    {
        User::addExp(config('custom.exp_for_like'), $event->recipe->user_id);
    }
}
