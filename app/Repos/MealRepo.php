<?php

namespace App\Repos;

use App\Models\Meal;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class MealRepo
{
    /**
     * @return \Illuminate\Support\Collection
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
