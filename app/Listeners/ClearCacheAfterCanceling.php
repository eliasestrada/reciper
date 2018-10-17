<?php

namespace App\Listeners;

use App\Events\RecipeGotCanceled;

class ClearCacheAfterCanceling
{
    /**
     * @param  RecipeGotCanceled  $event
     * @return void
     */
    public function handle(RecipeGotCanceled $event)
    {
        cache()->forget('unapproved_notif');
    }
}
