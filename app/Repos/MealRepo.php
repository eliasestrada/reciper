<?php

namespace App\Repos;

use App\Models\Meal;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class MealRepo
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        try {
            return Meal::get();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
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
        try {
            return cache()->rememberForever('meal', function () {
                return Meal::get()->toArray();
            });
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return [];
        }
    }
}
