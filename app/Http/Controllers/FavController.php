<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\View\View;

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
}
