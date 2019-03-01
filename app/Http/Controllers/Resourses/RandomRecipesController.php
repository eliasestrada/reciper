<?php

namespace App\Http\Controllers\Resourses;

use App\Repos\RecipeRepo;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesRandomResource;

class RandomRecipesController extends Controller
{
    /**
     * Returns js object of random recipes
     *
     * @param int $visitor_id
     * @return object|null
     */
    public function boot(int $visitor_id, RecipeRepo $recipe_repo): ?object
    {
        return RecipesRandomResource::collection(
            $recipe_repo->getRandomUnseen(12, 4, $visitor_id)
        );
    }
}
