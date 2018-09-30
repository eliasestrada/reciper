<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesRandomResource;
use App\Models\Recipe;
use App\Models\View;

class ApiRandomRecipesController extends Controller
{
    /**
     * @param int $visitor_id
     * @return object|null
     */
    public function boot(int $visitor_id): ?object
    {
        $visited = View::whereVisitorId($visitor_id)->pluck('recipe_id');
        $not_visited = $this->getRandomRecipes($visited);

        // If not enough recipes to display, show just random recipes
        if ($not_visited->count() < 3) {
            $not_visited = $this->getRandomRecipes();
        }

        return RecipesRandomResource::collection($not_visited);
    }

    /**
     * @param object|null $except
     */
    public function getRandomRecipes(?object $except = null)
    {
        $query = Recipe::inRandomOrder();

        if ($except) {
            $query->where($except->map(function ($id) {
                return ['id', '!=', $id];
            })->toArray());
        }
        return $query->done(1)->limit(7)->get(['id', 'image', 'title_' . lang()]);
    }
}
