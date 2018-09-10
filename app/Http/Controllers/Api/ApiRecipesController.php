<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\RecipesControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesRandomResource;
use App\Http\Resources\RecipesResource;
use App\Models\Category;
use App\Models\Like;
use App\Models\Recipe;
use App\Models\View;
use App\Models\Visitor;
use Illuminate\Http\Request;

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
     * @param int $visitor_id
     * @return object|null
     */
    public function random(int $visitor_id): ?object
    {
        $array_of_visited_recipes = View::whereVisitorId($visitor_id)
            ->pluck('recipe_id');

        // Get recipes all except those that visitor saw
        $not_visited_recipes = $this->getRecipesExcept($array_of_visited_recipes);

        // If not enough recipes to display, show just random recipes
        // with those that has been seen by visitor
        if ($not_visited_recipes->count() < 3) {
            $not_visited_recipes = $this->getRandomRecipes();
        }

        return RecipesRandomResource::collection($not_visited_recipes);
    }

    /**
     * @return object
     */
    public function categories(): ?object
    {
        return Category::get(['id', 'name_' . lang()]);
    }

    /**
     * @param integer $id of the recipe
     * @return integer
     */
    public function checkIfLiked($id)
    {
        $visitor = Visitor::whereIp(request()->ip())->first();
        $likes = $visitor->likes()->where('recipe_id', $id)->count();

        return $likes;
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function like($id): ?object
    {
        $visitor = Visitor::whereIp(request()->ip())->first();
        Like::create(['visitor_id' => $visitor->id, 'recipe_id' => $id]);

        return response()->json(['liked' => 1]);
    }

    /**
     * @param integer $id of the recipe
     * @return object
     */
    public function dislike($id): ?object
    {
        $visitor = Visitor::whereIp(request()->ip())->first();
        Like::where(['visitor_id' => $visitor->id, 'recipe_id' => $id])->delete();

        return response()->json(['liked' => 0]);
    }

    /**
     * @param [type] $hash
     * @param [type] $sql
     * @return void
     */
    public function makeQueryWithCriteria($hash, $sql)
    {
        switch ($hash) {
            case 'new':
                $sql->latest();
                break;
            case 'liked':
                $sql->withCount('likes');
                $sql->orderBy('likes_count', 'desc');
            case 'viewed':
                $sql->withCount('views');
                $sql->orderBy('views_count', 'desc');
                break;
            default:
                $sql->inRandomOrder();
        }
        return $sql->done(1);
    }

    /**
     * @param object|null $except
     */
    public function getRecipesExcept(?object $except)
    {
        $except = $except->map(function ($id) {
            return ['id', '!=', $id];
        })->toArray();

        return Recipe::inRandomOrder()
            ->where($except)
            ->done(1)
            ->limit(7)
            ->get();
    }

    public function getRandomRecipes()
    {
        return Recipe::inRandomOrder()
            ->done(1)
            ->limit(7)
            ->get();
    }
}
