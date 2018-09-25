<?php

namespace App\Listeners;

use App\Events\RecipeGotDrafted;

class ForgetCacheAfterDrafting
{
    /**
     * @param  RecipeGotDrafted  $event
     * @return void
     */
    public function handle(RecipeGotDrafted $event)
    {
        cache()->forget('popular_recipes');
        cache()->forget('random_recipes');
        cache()->forget('unapproved_notif');
        cache()->forget('search_suggest');
    }
}
