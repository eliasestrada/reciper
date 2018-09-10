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
