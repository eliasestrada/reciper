<?php

namespace App\Repos;

use App\Models\Meal;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class MealRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        try {
            return Meal::get();
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }

    /**
     * Selects common fields from db and caching them
     *
     * @throws \Illuminate\Database\QueryException
     * @return array
     */
    public function getWithCache(): array
    {
        try {
            return cache()->rememberForever('meal', function () {
                return Meal::get()->toArray();
            });
        } catch (QueryException $e) {
            return report_error($e, []);
        }
    }
}
