<?php

namespace App\Http\Controllers;

use App\Helpers\Traits\RecipeControllerHelpers;
use App\Http\Requests\Recipes\RecipeStoreRequest;
use App\Http\Requests\Recipes\RecipeUpdateRequest;
use App\Http\Responses\Controllers\Recipes\DestroyResponse;
use App\Http\Responses\Controllers\Recipes\EditResponse;
use App\Http\Responses\Controllers\Recipes\ShowResponse;
use App\Http\Responses\Controllers\Recipes\UpdateResponse;
use App\Models\Fav;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use App\Repos\FavRepo;
use App\Repos\MealRepo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View as ViewResponse;

class RecipeController extends Controller
{
    use RecipeControllerHelpers;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * @param \App\Repos\FavRepo
     * @return \Illuminate\View\View
     */
    public function index(FavRepo $favs): ViewResponse
    {
        return view('recipes.index', ['favs' => $favs->all()]);
    }

    /**
     * It will save the recipe to a database with title only
     *
     * @param \App\Http\Requests\Recipes\RecipeStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeStoreRequest $request): RedirectResponse
    {
        if ($this->checkForScriptTags($request)) {
            return back()->withError(trans('notifications.cant_use_script_tags'));
        }

        $recipe = user()->recipes()->create([
            _('title') => $request->title,
            'slug' => str_slug($request->title) . '-' . time(),
        ]);

        return redirect("/recipes/{$recipe->slug}/edit");
    }

    /**
     * It will show the recipe on a single page
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Recipes\ShowResponse
     */
    public function show(string $slug): ShowResponse
    {
        return new ShowResponse($slug);
    }

    /**
     * @param string $slug
     * @param \App\Repos\MealRepo $meal_repo
     * @return \App\Http\Responses\Controllers\Recipes\EditResponse
     */
    public function edit(string $slug, MealRepo $meal_repo): EditResponse
    {
        return new EditResponse($slug, $meal_repo);
    }

    /**
     * Update single recipe
     * This method triggers event RecipeIsReady
     *
     * @param \App\Http\Requests\Recipes\RecipeUpdateRequest $request
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Recipes\UpdateResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        return new UpdateResponse($recipe);
    }

    /**
     * Delete recipe form database
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Recipes\DestroyResponse
     */
    public function destroy(Recipe $recipe): DestroyResponse
    {
        return new DestroyResponse($recipe);
    }
}
