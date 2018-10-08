<?php

namespace App\Listeners;

use App\Events\UserIsOnline;

class UpdateStrikeDays
{
    /**
     * @param  UserIsOnline  $event
     * @return void
     */
    public function handle(UserIsOnline $event)
    {
        if (!request()->cookie('strk')) {
            $in_a_row = user()->streak_check <= now()->subDay() && user()->streak_check >= now()->subDays(2);
            $not_in_a_row = user()->streak_check <= now()->subDays(2);

            // If first time online in a day
            if ($in_a_row) {
                user()->update([
                    'streak_days' => user()->streak_days + 1,
                    'streak_check' => now(),
                ]);
            }
            if ($not_in_a_row) {
                user()->update([
                    'streak_days' => 0,
                    'streak_check' => now(),
                ]);
            }
            \Cookie::queue('strk', 1, 1440);
        }
    }
}
