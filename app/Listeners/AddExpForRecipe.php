<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\User;

class AddExpForRecipe
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        User::addPoints('xp', config('custom.xp_for_approve'), $event->recipe->user_id);
    }
}
