<?php

namespace App\Listeners;

use App\Events\UserIsOnline;
use App\Models\User;

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
