<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesRandomResource;
use App\Models\Recipe;

class RandomRecipesController extends Controller
{
    /**
     * Returns js object of random recipes
     *
     * @param int $visitor_id
     * @return object|null
     */
    public function boot(int $visitor_id): ?object
    {
        return RecipesRandomResource::collection(Recipe::getRandomUnseen(12, 4, $visitor_id));
    }
}
