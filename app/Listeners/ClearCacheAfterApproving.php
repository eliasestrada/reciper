<?php

namespace App\Listeners;

use App\Events\RecipeGotApproved;

class ClearCacheAfterApproving
{
    /**
     * @param  RecipeGotApproved  $event
     * @return void
     */
    public function handle(RecipeGotApproved $event)
    {
        cache()->forget('all_unapproved');
        cache()->forget('search_suggest');
    }
}
