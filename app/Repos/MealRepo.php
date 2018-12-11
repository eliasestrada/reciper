<?php

namespace App\Repos;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class MealRepo
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        try {
            return Meal::get(['id', 'name_' . LANG()]);
        } catch (QueryException $e) {
            no_connection_rror($e, __CLASS__);
            return collect();
        }
    }

    /**
     * Selects common fields from db and caching them
     *
     * @return array
     */
    public function getWithCache(): array
    {
        return cache()->rememberForever('meal', function () {
            return Meal::select('id', 'name_' . LANG() . ' as name')->get()->toArray();
        });
    }
}
