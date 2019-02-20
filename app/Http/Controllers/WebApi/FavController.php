<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\Popularity;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;

class FavController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Add recipe to favorites
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\Response
     */
    public function store(Recipe $recipe): Response
    {
        if (!$recipe) {
            return response('fail', 403);
        }

        if (user()->favs()->whereRecipeId($recipe->id)->exists()) {
            user()->favs()->whereRecipeId($recipe->id)->delete();
            Popularity::remove(config('custom.popularity_for_favs'), $recipe->user_id);

            return response('', 200);
        }

        user()->favs()->create(['recipe_id' => $recipe->id]);
        Popularity::add(config('custom.popularity_for_favs'), $recipe->user_id);

        return response('active', 200);
    }
}
