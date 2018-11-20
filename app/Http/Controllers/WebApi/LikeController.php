<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\Popularity;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * Add like to particular recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\Response
     */
    public function store(Recipe $recipe): Response
    {
        if (!$recipe) {
            return response('fail', 403);
        }

        if (user()->likes()->whereRecipeId($recipe->id)->exists()) {
            user()->likes()->whereRecipeId($recipe->id)->delete();
            Popularity::remove(config('custom.popularity_for_like'), $recipe->user_id);

            return response('', 200);
        }

        user()->likes()->create(['recipe_id' => $recipe->id]);
        Popularity::add(config('custom.popularity_for_like'), $recipe->user_id);

        return response('active', 200);
    }
}
