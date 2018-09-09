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
     * @return object
     */
    public function index(): ?object
    {
        $recipes = Recipe::query()
            ->approved(1)
            ->ready(1)
            ->latest()
            ->paginate(8);

        return RecipesResource::collection($recipes);
    }

    /**
     * @param integer $id of the recipe
     * @return string
     */
    public function destroy($id): string
    {
        $recipe = Recipe::find($id);

        $this->deleteOldImage($recipe->image);
        $recipe->categories()->detach();
        $recipe->likes()->delete();

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
     * @param integer $id of the recipe
     * @return object
     */
    public function random($visitor_id): ?object
    {
        // Find recipes that visitor saw
        $except_visited = View::whereVisitorId($visitor_id)
            ->pluck('recipe_id')
            ->map(function ($id) {
                return ['id', '!=', $id];
            })->toArray();

        // Get recipes all except those that visitor saw
        $not_seen_recipes = Recipe::inRandomOrder()
            ->where($except_visited)
            ->ready(1)
            ->approved(1)
            ->limit(7)
            ->get();

        // If not enough recipes to display, show just random recipes
        // with those that has been seen by visitor
        if ($not_seen_recipes->count() < 7) {
            $not_seen_recipes = Recipe::inRandomOrder()
                ->ready(1)
                ->approved(1)
                ->limit(7)
                ->get();
        }

        return RecipesRandomResource::collection($not_seen_recipes);
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
}
