<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.index', ['users' => User::paginate(36)->onEachSide(1)]);
    }

    /**
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->withCount('views')
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        return view('users.show', compact('recipes', 'user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function my_recipes()
    {
        $recipes_ready = Recipe::whereUserId(user()->id)
            ->selectBasic()
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $recipes_unready = Recipe::whereUserId(user()->id)
            ->selectBasic()
            ->approved(0)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $favs = Recipe::query()
            ->join('favs', 'favs.recipe_id', '=', 'recipes.id')
            ->selectBasic(['recipe_id'], ['id'])
            ->where('favs.user_id', user()->id)
            ->orderBy('favs.id', 'desc')
            ->done(1)
            ->paginate(20)
            ->onEachSide(1);

        $favs->map(function ($recipe) {
            $recipe->id = $recipe->recipe_id;
        });

        return view('users.other.my-recipes', compact(
            'recipes_ready', 'recipes_unready', 'favs'
        ));
    }
}
