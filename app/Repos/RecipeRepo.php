<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo
{
    /**
     * @param string $slug
     * @return \App\Models\Recipe
     */
    public function find(string $slug): Recipe
    {
        return Recipe::whereSlug($slug)->first();
    }

    /**
     * @return mixed
     */
    public function paginateUnapprovedWaiting()
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), 0)
                ->approved(0)
                ->ready(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @return mixed
     */
    public function paginateUnapprovedChecking()
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), '!=', 0)
                ->approved(0)
                ->ready(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function paginateMyApproves(int $user_id)
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), $user_id)
                ->done(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @param int $user_id
     * @return int
     */
    public function getIdOfTheRecipeThatUserIsChecking(int $user_id): ?int
    {
        try {
            return Recipe::where(_('approver_id', true), $user_id)
                ->approved(0)
                ->ready(1)
                ->value('id');
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return null;
        }
    }

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

    /**
     * Returns only those recipes that user haven't seen, if there no recipes
     * the he haven't seen, shows just random recipes
     *
     * @param int $limit Limit results
     * @param int|null $visitor_id
     * @param \App\Repos\ViewRepo|null $view_repo
     * @return \Illuminate\Support\Collection
     */
    public static function getRandomUnseen(int $limit = 12, ?int $visitor_id = null, ?ViewRepo $view_repo = null): Collection
    {
        $viewed = ($view_repo ?? new ViewRepo)->pluckViewedRecipeIds($visitor_id);

        /** @var array $where_condition */
        $where_condition = $viewed->map(function ($recipe_id) {
            return ['id', '!=', $recipe_id];
        })->toArray();

        /** @var \Closure $select_unseen_callback */
        $select_unseen_callback = function ($query) use ($where_condition) {
            return $query->where($where_condition);
        };

        /** @var bool $enough_recipes Check if recipes result is less than half of the limit */
        $enough_recipes = Recipe::where($where_condition)->done(1)->count() < $limit / 2;

        return Recipe::with(['favs', 'likes'])
                ->select(['id', 'slug', 'image', _('title'), _('intro')])
                ->inRandomOrder()
                ->when($enough_recipes, $select_unseen_callback)
                ->done(1)
                ->limit($limit)
                ->get();
    }
}
