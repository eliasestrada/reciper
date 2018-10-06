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
        User::removePoints('exp', config('custom.exp_for_approve'), $event->recipe->user_id);
    }
}
