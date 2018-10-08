<?php

namespace App\Listeners;

use App\Events\UserIsOnline;
use App\Helpers\Xp;

class UpdateStrikeDays
{
    /**
     * @param  UserIsOnline  $event
     * @return void
     */
    public function handle(UserIsOnline $event)
    {
        if (!request()->cookie('strk')) {
            \Cookie::queue('strk', 1, 1440);

            $in_a_row = user()->streak_check <= now()->subDay() && user()->streak_check >= now()->subDays(2);
            $not_in_a_row = user()->streak_check <= now()->subDays(2);

            if ($in_a_row) {
                user()->update(['streak_days' => user()->streak_days + 1, 'streak_check' => now()]);
                Xp::addForStreak(user());
            }

            if ($not_in_a_row) {
                user()->update(['streak_days' => 0, 'streak_check' => now()]);
            }
        }
    }
}
