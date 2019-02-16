<?php

namespace App\Http\Controllers;

use App\Helpers\Popularity;
use App\Helpers\Traits\RecipeControllerHelpers;
use App\Helpers\Xp;
use App\Http\Requests\Recipes\RecipeStoreRequest;
use App\Http\Requests\Recipes\RecipeUpdateRequest;
use App\Http\Responses\Controllers\Recipes\DestroyResponse;
use App\Http\Responses\Controllers\Recipes\EditResponse;
use App\Http\Responses\Controllers\Recipes\UpdateResponse;
use App\Models\Fav;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use App\Repos\FavRepo;
use App\Repos\MealRepo;
use Illuminate\Database\QueryException;
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
     * @return mixed
     */
    public function show(string $slug)
    {
        $recipe = Recipe::whereSlug($slug)->first();

        // Rules for visitors
        if (!user() && !$recipe->isDone()) {
            return redirect('/recipes')->withError(trans('recipes.no_rights_to_see'));
        }

        // Rules for auth users
        if (user()) {
            if (!user()->hasRecipe($recipe->id) && !$recipe->isReady()) {
                return redirect('/recipes')->withError(trans('recipes.not_written'));
            }

            if (!user()->hasRecipe($recipe->id) && !$recipe->isApproved()) {
                return redirect('/recipes')->withError(trans('recipes.not_approved'));
            }
        }

        // Mark that visitor saw the recipe if he didn't
        // Else increment visits column by one
        if ($recipe->views()->whereVisitorId(visitor_id())->doesntExist()) {
            try {
                $recipe->views()->create(['visitor_id' => visitor_id()]);
                if ($recipe->user_id) {
                    Popularity::add(config('custom.popularity_for_view'), $recipe->user_id);
                }
            } catch (QueryException $e) {}
        } else {
            $recipe->views()->whereVisitorId(visitor_id())->increment('visits');
        }

        return view('recipes.show', [
            'recipe' => $recipe,
            'xp' => $recipe->user ? new Xp($recipe->user) : [],
            'cookie' => getCookie('r_font_size') ? getCookie('r_font_size') : '1.0',
        ]);
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
