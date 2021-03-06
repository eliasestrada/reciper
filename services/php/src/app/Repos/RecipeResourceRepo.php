<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeResourceRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateAllSimple(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::whereSimple(1)->done(1)->paginate($pagin);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }
    /**
     * Searching for recipes with specific meal time
     *
     * @throws \Illuminate\Database\QueryException
     * @param string $meal Meal time
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateWithMealTime(string $meal, ?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::with('meal:name_en')
                ->whereHas('meal', function ($query) use ($meal, $pagin) {
                    $query->whereNameEn($meal);
                })
                ->done(1)
                ->paginate($pagin);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $pagin Pagination value
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateLatest(?int $pagin = 8): ?LengthAwarePaginator
    {
        try {
            return Recipe::latest()->done(1)->paginate($pagin);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * Searching for recipes with provided category id
     * 
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e);
        }
    }
}
