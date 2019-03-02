<?php

namespace App\Repos\Resources;

use App\Models\Recipe;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo
{
    /**
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateByLikes(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->done(1)
                ->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateAllSimple(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::whereSimple(1)->done(1)->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
    /**
     * Searching for recipes with specific meal time
     *
     * @param string $meal Meal time
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateWithMealTime(string $meal, ?int $pagin = 8): ?LengthAwarePaginator
    {
        /** @var \Closure $queryWithMealCallback */
        $queryWithMealCallback = function ($query) use ($meal, $pagin) {
            $query->whereNameEn($meal);
        };

        try {
            return Recipe::with('meal:name_en')
                ->whereHas('meal', $queryWithMealCallback)
                ->done(1)
                ->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param int $visitor_id
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateViewedByVisitor(int $visitor_id, ?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            $result = Recipe::join('views', 'views.recipe_id', '=', 'recipes.id')
                ->where('views.visitor_id', $visitor_id)
                ->orderBy('views.id', 'desc')
                ->done(1)
                ->paginate($pagin);

            $result->map(function ($r) {
                $r->id = $r->recipe_id;
            });

            return $result;
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateLatest(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::latest()->done(1)->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * Searching for recipes with provided category id
     * 
     * @param int $category_id
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateWithCategoryId(int $category_id, ?int $pagin = 8): ?LengthAwarePaginator
    {
        /** @var \Closure $queryWithCategoryCallback */
        $queryWithCategoryCallback = function ($query) use ($category_id, $pagin) {
            $query->whereId(str_replace('category=', '', $category_id));
        };

        try {
            return Recipe::whereHas('categories', $queryWithCategoryCallback)
                ->done(1)
                ->paginate($pagin);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }
}
