<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\RecipesControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Models\Recipe;
use App\Models\Visitor;

class ApiRecipesController extends Controller
{
    use RecipesControllerHelpers;

    /**
     * @param null|string $hash
     * @return null|object
     */
    public function index(?string $hash = null): ?object
    {
        return RecipesResource::collection(
            $this->makeQueryWithCriteria($hash, Recipe::query(), 8));
    }

    /**
     * @param int $id of the recipe
     * @return string
     */
    public function destroy(int $id): string
    {
        $recipe = Recipe::find($id);

        $this->deleteOldImage($recipe->image);

        $recipe->categories()->detach();
        $recipe->likes()->delete();
        $recipe->views()->delete();

        if ($recipe->delete()) {
            cache()->forget('popular_recipes');
            cache()->forget('random_recipes');
            cache()->forget('unapproved_notif');
            cache()->forget('search_suggest');

            return 'success';
        }

        logger()->error('An error occured while trying to delete recipe. Recipe data: ' . $recipe);
        return 'failed';
    }

    /**
     * @param string|null $hash
     * @param $sql
     * @param int|null $pagin
     * @return void
     */
    public function makeQueryWithCriteria(?string $hash = 'new', $sql, ?int $pagin = 8)
    {
        if ($hash == 'new') {
            return $sql->latest()->done(1)->paginate($pagin);
        }

        if ($hash == 'most_liked') {
            return $sql->withCount('likes')->orderBy('likes_count', 'desc')->done(1)->paginate($pagin);
        }

        if ($hash == 'my_viewes') {
            $result = $sql->join('views', 'views.recipe_id', '=', 'recipes.id')
                ->where('views.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                ->selectBasic(['recipe_id'], ['id'])
                ->orderBy('views.id', 'desc')
                ->done(1)
                ->paginate($pagin);

            $result->map(function ($r) {
                $r->id = $r->recipe_id;
            });

            return $result;
        }

        if ($hash == 'my_likes') {
            $result = $sql->join('likes', 'likes.recipe_id', '=', 'recipes.id')
                ->where('likes.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                ->selectBasic(['recipe_id'], ['id'])
                ->orderBy('likes.id', 'desc')
                ->done(1)
                ->paginate($pagin);

            $result->map(function ($r) {
                $r->id = $r->recipe_id;
            });

            return $result;
        }

        if ($hash == 'simple') {
            return $sql->whereSimple(1)->selectBasic()->done(1)->paginate($pagin);
        }

        // Searching for recipes with category
        if (str_contains($hash, 'category=')) {
            return $sql->whereHas('categories', function ($query) use ($hash) {
                $query->whereId(str_replace('category=', '', $hash));
            })->done(1)->paginate($pagin);
        }

        // Searching for recipes with meal time
        if ($hash == 'breakfast' || $hash == 'lunch' || $hash == 'dinner') {
            return $sql->with('meal')->whereHas('meal', function ($query) use ($hash) {
                $query->whereNameEn($hash);
            })->done(1)->paginate($pagin);
        }

        return $sql->latest()->done(1)->paginate($pagin);
    }
}
