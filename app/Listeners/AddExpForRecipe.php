<?php

namespace App\Listeners;

use App\Models\Xp;
use App\Models\User;
use App\Events\RecipeGotApproved;

class AddExpForRecipe
{
    /**
     * Add xp point to a user for the recipe
     *
     * @param RecipeGotApproved  $event
     * @param \App\Models\Xp|null $xp
     * @return void
     */
    public function handle(RecipeGotApproved $event, ?Xp $xp = null)
    {
        if (!$event->recipe->isPublished()) {
            ($xp ?? new Xp)
                ->takeUser(User::find($event->recipe->user_id))
                ->add(config('custom.xp_for_approve'));
        }
    }
}
