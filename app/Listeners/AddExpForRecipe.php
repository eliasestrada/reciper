<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;
use App\Helpers\Xp;

class AddExpForRecipe
{
    /**
     * Add exp points and mark recipe as approved if it wasn't approved before
     *
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        if (!$event->recipe->isPublished()) {
            Xp::add(config('custom.xp_for_approve'), $event->recipe->user_id);

            $event->recipe->update([
                'published_' . LANG() => 1,
            ]);
        }
    }
}
