<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;

class UpdateRecipeAfterCanceling
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        $event->recipe->update(['ready_' . lang() => 0]);
    }
}
