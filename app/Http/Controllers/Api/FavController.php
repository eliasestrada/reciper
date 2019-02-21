<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Popularity;
use App\Http\Controllers\Controller;

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
     * Add recipe to list of favorite recipes
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\Response|void
     */
    public function store(Recipe $recipe)
    {
        $popularity = new Popularity(User::find($recipe->user_id));

        if (user()->favs()->whereRecipeId($recipe->id)->exists()) {
            user()->favs()->whereRecipeId($recipe->id)->delete();
            $popularity->remove(config('custom.popularity_for_favs'));
        } else {
            user()->favs()->create(['recipe_id' => $recipe->id]);
            $popularity->add(config('custom.popularity_for_favs'));
            return response('active');
        }
    }
}
