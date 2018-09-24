<?php

namespace App\Listeners;

use App\Events\RecipeGotDrafted;
use App\Models\User;

class RemoveExpForDrafting
{
    /**
     * @param  RecipeGotDrafted  $event
     * @return void
     */
    public function handle(RecipeGotDrafted $event)
    {
        User::removeExp(5, $event->recipe->user_id);
    }
}
