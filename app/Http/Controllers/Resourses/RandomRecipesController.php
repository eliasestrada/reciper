<?php

namespace App\Http\Controllers\Resourses;

use App\Repos\RecipeRepo;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesRandomResource;
use App\Repos\ViewRepo;

class RandomRecipesController extends Controller
{
    /**
     * Returns js object of random recipes
     *
     * @param int $visitor_id
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Repos\ViewRepo $view_repo
     * @return object|null
     */
    public function boot(int $visitor_id, RecipeRepo $recipe_repo, ViewRepo $view_repo): ?object
    {
        return RecipesRandomResource::collection(
            $recipe_repo->getRandomUnseen(12, $visitor_id, $view_repo)
        );
    }
}
