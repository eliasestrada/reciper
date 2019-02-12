<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\Popularity;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FavsController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show page with recipes of particular category
     *
     * @param int $category
     * @return \Illuminate\View\View
     */
    public function index(int $category = 1): View
    {
        $query = Recipe::query()
            ->join('favs', 'favs.recipe_id', '=', 'recipes.id')
            ->where('favs.user_id', user()->id)
            ->orderBy('favs.id', 'desc');

        if ($category !== 1) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->whereId($category);
            });
        }

        $recipes = $query->done(1)
            ->paginate(20)
            ->onEachSide(1);

        $recipes->map(function ($recipe) {
            $recipe->id = $recipe->recipe_id;
        });

        return view('favs.index', compact('recipes'));
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
