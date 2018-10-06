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
        User::addPoints('exp', config('custom.exp_for_approve'), $event->recipe->user_id);
    }
}
