<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use App\Repos\UserRepo;
use App\Models\Popularity;
use Illuminate\Http\Response;
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
     * @param \App\Models\Popularity $popularity
     * @param \App\Repos\UserRepo $user_repo
     * @return \Illuminate\Http\Response|null
     */
    public function store(Recipe $recipe, Popularity $popularity, UserRepo $user_repo): ?Response
    {
        $popularity = $popularity->takeUser(
            $user_repo->find($recipe->user_id)
        );

        if (user()->favs()->whereRecipeId($recipe->id)->exists()) {
            user()->favs()->whereRecipeId($recipe->id)->delete();
            $popularity->remove(config('custom.popularity_for_favs'));
            return null;
        }

        user()->favs()->create(['recipe_id' => $recipe->id]);
        $popularity->add(config('custom.popularity_for_favs'));
        return response('active');
    }
}
