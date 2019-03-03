<?php

namespace App\Repos\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

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
     * @param string $slug
     * @return \App\Models\Recipe
     */
    public function findWithAuthor(string $slug): Recipe
    {
        return Recipe::with('user:id,username,photo,name,xp')
            ->whereSlug($slug)
            ->first();
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
            return report_error($e, collect());
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
            report_error($e, __CLASS__);
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
            report_error($e, __CLASS__);
            return collect();
        }
    }

    /**
     * @param int $user_id
     * @return string
     */
    public function getSlugOfTheRecipeThatUserIsChecking(int $user_id): ?string
    {
        try {
            return Recipe::where(_('approver_id', true), $user_id)
                ->approved(0)
                ->ready(1)
                ->value('slug');
        } catch (QueryException $e) {
            report_error($e, __CLASS__);
            return null;
        }
    }

    /**
     * Returns only those recipes that user haven't seen, if there no recipes
     * the he haven't seen, shows just random recipes
     *
     * @param int $limit Limit results
     * @param int|null $visitor_id
     * @param \App\Repos\Controllers\ViewRepo|null $view_repo
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
