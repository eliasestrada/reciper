<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Models\Xp;
use App\Models\User;

class AddExpForRecipe
{
    /**
     * Add xp point to a user for the recipe
     *
     * @param RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        if (!$event->recipe->isPublished()) {
            $xp = new Xp(User::find($event->recipe->user_id));
            $xp->add(config('custom.xp_for_approve'));
        }
    }
}
