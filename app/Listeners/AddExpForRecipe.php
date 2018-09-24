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
        User::addExp(5, $event->recipe->user_id);
    }
}
