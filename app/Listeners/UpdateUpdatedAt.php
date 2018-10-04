<?php

namespace App\Listeners;

use App\Events\UserVisitedPage;
use App\Models\User;

class UpdateUpdatedAt
{
    /**
     * Handle the event.
     *
     * @param  UserVisitedPage  $event
     * @return void
     */
    public function handle(UserVisitedPage $event)
    {
        User::whereId(user()->id)->update(['updated_at' => now()]);
    }
}
