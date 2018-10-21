<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;

class UpdateRecipeAfterApproving
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        $event->recipe->update(['approved_' . LANG() => 1]);
    }
}
