<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\RecipesControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Models\Category;
use App\Models\Recipe;

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
            cache()->forget('all_unapproved');

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
            $sql->latest();
            return $sql->done(1);
        }

        if ($hash == 'liked') {
            $sql->withCount('likes');
            $sql->orderBy('likes_count', 'desc');
            return $sql->done(1);
        }

        if ($hash == 'viewed') {
            $sql->withCount('views');
            $sql->orderBy('views_count', 'desc');
            return $sql->done(1);
        }

        if ($hash == 'simple') {
            $sql->whereSimple(1);
            return $sql->done(1);
        }

        // Searching for recipes with category
        if (str_contains($hash, 'category=')) {
            $sql->with('categories')->whereHas('categories', function ($query) use ($hash) {
                $query->whereId(str_replace('category=', '', $hash));
            });
            return $sql->done(1);
        }

        // Searching for recipes with meal time
        if ($hash == 'breakfast' || $hash == 'lunch' || $hash == 'dinner') {
            $sql->with('meal')->whereHas('meal', function ($query) use ($hash) {
                $query->whereNameEn($hash);
            });
            return $sql->done(1);
        }

        return $sql->inRandomOrder()->done(1);
    }
}
