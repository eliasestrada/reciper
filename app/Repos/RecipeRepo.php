<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepo
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @param string $slug
     * @return \App\Models\Recipe|null
     */
    public function find(string $slug): ?Recipe
    {
        try {
            return Recipe::whereSlug($slug)->first();
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param string $slug
     * @return \App\Models\Recipe|null
     */
    public function findWithAuthor(string $slug): ?Recipe
    {
        try {
            return Recipe::with('user:id,username,photo,name,xp')
                ->whereSlug($slug)
                ->first();
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e, collect());
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
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
            return report_error($e, collect());
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $user_id
     * @return mixed
     */
    public function paginateMyApproves(?int $user_id)
    {
        try {
            return Recipe::oldest()
                ->where(_('approver_id', true), $user_id)
                ->done(1)
                ->paginate(30)
                ->onEachSide(1);
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int|null $user_id
     * @return string
     */
    public function getRecipeSlugThatAdminIsChecking(?int $user_id): ?string
    {
        try {
            return Recipe::where(_('approver_id', true), $user_id)
                ->approved(0)
                ->ready(1)
                ->value('slug');
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * Returns only those recipes that user haven't seen, if there no recipes
     * returns just random recipes without condition
     *
     * @throws \Illuminate\Database\QueryException
     * @param int $limit Limit how many recipes take from database
     * @param int $visitor_id
     * @param \App\Repos\ViewRepo $view_repo
     * @return \Illuminate\Support\Collection
     */
    public static function getRandomUnseen(int $limit = 12, int $visitor_id, ViewRepo $view_repo): Collection
    {
        /** @var array Array of arrays for use in where statement query */
        $where_condition = array_map(function ($viewed_recipe_id) {
            return ['id', '!=', $viewed_recipe_id];
        }, $view_repo->getViewedRecipeIds($visitor_id));

        try {
            /** @var int How many recipes visitor haven't seen */
            $havent_seen_recipes = Recipe::where($where_condition)
                ->done(1)
                ->count();
        } catch (QueryException $e) {
            $havent_seen_recipes = 0;
            logger()->error($e);
        }

        try {
            return Recipe::with(['favs', 'likes'])
                ->select(['id', 'slug', 'image', _('title'), _('intro')])
                ->inRandomOrder()
                /** If not seen recipes more than half of all displayed, apply where statement */
                ->when($havent_seen_recipes > $limit / 2, function ($query) use ($where_condition) {
                    return $query->where($where_condition);
                })
                ->done(1)
                ->limit($limit)
                ->get();
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $user_id
     * @param array|null $columns
     * @return \Illuminate\Pagination\LengthAwarePaginator|null
     */
    public function paginateUserRecipesWithCountColumns(int $user_id, ?array $columns = null): ?LengthAwarePaginator
    {
        try {
            return Recipe::whereUserId($user_id)
                ->when($columns, function ($query) use ($columns) {
                    $query->withCount($columns);
                })
                ->done(1)
                ->latest()
                ->paginate(20)
                ->onEachSide(1);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $user_id
     * @param array|null $columns
     * @return Illuminate\Support\Collection
     */
    public function getUserRecipesForTheLastYear(int $user_id, ?array $columns = null): Collection
    {
        try {
            return Recipe::whereUserId($user_id)
                ->where('created_at', '>=', now()->subYear())
                ->get($columns ?? ['id', 'created_at']);
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }
}
