<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Helpers\Xp;

class AddExpForRecipe
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        Xp::add(config('custom.xp_for_approve'), $event->recipe->user_id);
    }
}
