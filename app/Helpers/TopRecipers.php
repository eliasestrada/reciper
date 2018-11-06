<?php

namespace App\Helpers;

use DB;

class TopRecipers
{
    /**
     * Adds username to top_recipers table
     * @param array $usernames
     * @return bool
     */
    public static function add(array $usernames): bool
    {
        $winners = array_map(function($username) {
            return compact('username');
        }, $usernames);

        return DB::table('top_recipers')->insert($winners);
    }
}
