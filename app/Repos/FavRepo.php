<?php

namespace App\Repos;

use App\Models\Fav;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class FavRepo
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        try {
            return Fav::get(['recipe_id', 'user_id']);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }
}
