<?php

namespace App\Models;

class Popularity
{
    /**
     * @param float $points
     * @param int $user_id
     * @return void
     */
    public static function add(float $points, int $user_id)
    {
        User::whereId($user_id)->increment('popularity', $points);
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
