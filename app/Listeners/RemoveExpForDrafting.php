<?php

namespace App\Listeners;

use App\Events\RecipeGotDrafted;
use App\Helpers\Xp;

class RemoveExpForDrafting
{
    /**
     * @param  RecipeGotDrafted  $event
     * @return void
     */
    public function handle(RecipeGotDrafted $event)
    {
        Xp::remove(config('custom.xp_for_approve'), $event->recipe->user_id);
    }
}
