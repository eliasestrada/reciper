<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserIsOnline;

class UpdateUpdatedAtColumn
{
    /**
     * @param  UserIsOnline  $event
     * @return void
     */
    public function handle(UserIsOnline $event)
    {
        User::whereId(user()->id)->update(['online_check' => now()]);
    }
}
