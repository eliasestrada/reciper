<?php

namespace App\Http\Controllers;

use App\Helpers\Popularity;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class ApiFavsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($recipe_id)
    {
        if (!$recipe_id || !is_numeric($recipe_id) || Recipe::whereId($recipe_id)->doesntExist()) {
            return response('fail', 403);
        }

        $recipe = Recipe::find($recipe_id);

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
