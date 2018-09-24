<?php

namespace App\Listeners;

use App\Events\RecipeGotViewed;
use App\Models\User;

class AddExpForView
{
    /**
     * @param  RecipeGotViewed  $event
     * @return void
     */
    public function handle(RecipeGotViewed $event)
    {
        User::addExp(config('custom.exp_for_view'), $event->recipe->user_id);
    }
}
