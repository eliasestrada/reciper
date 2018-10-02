<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\RecipesControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Models\Category;
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
            $this->makeQueryWithCriteria($hash, Recipe::query())->paginate(8)
        );
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
     * @return object
     */
    public function categories(): ?object
    {
        return Category::get(['id', 'name_' . lang()]);
    }

    /**
     * @param [type] $hash
     * @param [type] $sql
     * @return void
     */
    public function makeQueryWithCriteria($hash, $sql)
    {
        if ($hash == 'new') {
            return $sql->latest()->done(1);
        }

        if ($hash == 'most_liked') {
            return $sql->withCount('likes')->orderBy('likes_count', 'desc')->done(1);
        }

        if ($hash == 'my_viewes') {
            return $sql->join('views', 'views.recipe_id', '=', 'recipes.id')
                ->where('views.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                ->orderBy('views.id', 'asc')
                ->done(1);
        }

        if ($hash == 'simple') {
            return $sql->whereSimple(1)->selectBasic()->done(11);
        }

        if ($hash == 'my_likes') {
            return $sql->join('likes', 'likes.recipe_id', '=', 'recipes.id')
                ->where('likes.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                ->orderBy('likes.id', 'asc')
                ->done(1);
        }

        // Searching for recipes with category
        if (str_contains($hash, 'category=')) {
            return $sql->with('categories')->whereHas('categories', function ($query) use ($hash) {
                $query->whereId(str_replace('category=', '', $hash));
            })->done(1);
        }

        // Searching for recipes with meal time
        if ($hash == 'breakfast' || $hash == 'lunch' || $hash == 'dinner') {
            return $sql->with('meal')->whereHas('meal', function ($query) use ($hash) {
                $query->whereNameEn($hash);
            })->done(1);
        }

        return $sql->latest()->done(1);
    }
}
