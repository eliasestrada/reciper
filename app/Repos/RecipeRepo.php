<?php

namespace App\Repos;

use App\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

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
            return report_error($e, collect());
        }
    }

    /**
     * @throws \Illuminate\Database\QueryException
     * @param int $user_id
     * @return string
     */
    public function getRecipeSlugThatAdminIsChecking(int $user_id): ?string
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
     * the he haven't seen, shows just random recipes
     *
     * @throws \Illuminate\Database\QueryException
     * @param int $limit Limit results
     * @param int|null $visitor_id
     * @param \App\Repos\ViewRepo|null $view_repo
     * @return \Illuminate\Support\Collection
     */
    public static function getRandomUnseen(int $limit = 12, ?int $visitor_id = null, ?ViewRepo $view_repo = null): Collection
    {
        $viewed = ($view_repo ?? new ViewRepo)->pluckViewedRecipeIds($visitor_id);

        $where_condition = $viewed->map(function ($recipe_id) {
            return ['id', '!=', $recipe_id];
        })->toArray();

        try {
            $enough_recipes = Recipe::where($where_condition)
                ->done(1)
                ->count() < $limit / 2;
        } catch (QueryException $e) {
            $enough_recipes = false;
        }

        try {
            return Recipe::with(['favs', 'likes'])
                ->select(['id', 'slug', 'image', _('title'), _('intro')])
                ->inRandomOrder()
                ->when($enough_recipes, function ($query) use ($where_condition) {
                    return $query->where($where_condition);
                })
                ->done(1)
                ->limit($limit)
                ->get();
        } catch (QueryException $e) {
            return report_error($e, collect());
        }
    }
}
