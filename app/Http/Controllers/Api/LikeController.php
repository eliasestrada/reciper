<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Popularity;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Add like to particular recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\Response|void
     */
    public function store(Recipe $recipe)
    {
        $popularity = new Popularity(User::find($recipe->user_id));

        if (user()->likes()->whereRecipeId($recipe->id)->exists()) {
            user()->likes()->whereRecipeId($recipe->id)->delete();
            $popularity->remove(config('custom.popularity_for_like'));
        } else {
            user()->likes()->create(['recipe_id' => $recipe->id]);
            $popularity->add(config('custom.popularity_for_like'));
            return response('active');
        }
    }
}
