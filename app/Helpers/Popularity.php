<?php

namespace App\Helpers;

use App\Models\User;

class Popularity
{
    /**
     * @param float $points
     * @param int $user_id
     * @return void
     */
    public static function add(float $points, int $user_id)
    {
        $xp = User::whereId($user_id)->value('xp');

        if ($xp <= (config('custom.max_xp') - $points)) {
            User::whereId($user_id)->increment('popularity', $points);
        } else {
            User::whereId($user_id)->increment('popularity', config('custom.max_xp') - $xp);
        }
    }

    /**
     * @param float $points
     * @param int $user_id
     * @return void
     */
    public static function remove(float $points, int $user_id)
    {
        User::whereId($user_id)->decrement('popularity', $points);
    }

}
