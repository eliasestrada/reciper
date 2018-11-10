<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\Popularity;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * @param  string $recipe_id
     * @return Response
     */
    public function store($recipe_id): Response
    {
        if (!$recipe_id || !is_numeric($recipe_id) || Recipe::whereId($recipe_id)->doesntExist()) {
            return response('fail', 403);
        }

        $recipe = Recipe::find($recipe_id);

        if (user()->likes()->whereRecipeId($recipe->id)->exists()) {
            user()->likes()->whereRecipeId($recipe->id)->delete();
            Popularity::remove(config('custom.popularity_for_favs'), $recipe->user_id);

            return response('', 200);
        }

        user()->likes()->create(['recipe_id' => $recipe->id]);
        Popularity::add(config('custom.popularity_for_favs'), $recipe->user_id);

        return response('active', 200);
    }
}
