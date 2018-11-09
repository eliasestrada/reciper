<?php

namespace App\Http\Controllers;

use App\Helpers\Popularity;
use App\Helpers\Traits\RecipesControllerHelpers;
use App\Helpers\Xp;
use App\Http\Requests\Recipes\RecipeStoreRequest;
use App\Http\Requests\Recipes\RecipeUpdateRequest;
use App\Http\Responses\Controllers\RecipeUpdateResponse;
use App\Jobs\DeleteFileJob;
use App\Models\Fav;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use Illuminate\Database\QueryException;
use Predis\Connection\ConnectionException;

class RecipesController extends Controller
{
    use RecipesControllerHelpers;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            return view('recipes.index', [
                'favs' => Fav::get(['recipe_id', 'user_id']),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('recipes.index');
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('recipes.create', [
            'meal' => Meal::get(['id', 'name_' . LANG()]),
        ]);
    }

    /**
     * It will save the recipe to a database with title only
     * @param RecipeStoreRequest $request
     */
    public function store(RecipeStoreRequest $request)
    {
        if ($this->checkForScriptTags($request)) {
            return back()->withError(trans('notifications.cant_use_script_tags'));
        }

        $recipe = $this->createRecipe($request);

        return redirect("/recipes/$recipe->slug/edit");
    }

    /**
     * It will show the recipe on a single page
     * @param string $slug
     * @return \Illuminate\View\View
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
            $recipe->views()->create(['visitor_id' => visitor_id()]);
            Popularity::add(config('custom.popularity_for_view'), $recipe->user_id);
        } else {
            $recipe->views()->whereVisitorId(visitor_id())->increment('visits');
        }

        return view('recipes.show', [
            'recipe' => $recipe,
            'xp' => new Xp($recipe->user),
            'cookie' => getCookie('r_font_size') ? getCookie('r_font_size') : '1.0',
        ]);
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit(string $slug)
    {
        $recipe = Recipe::whereSlug($slug)->first();

        // Check for correct user
        if (!user()->hasRecipe($recipe->id) || $recipe->isReady()) {
            return redirect('/recipes')->withError(
                trans('recipes.cant_edit_ready_recipe')
            );
        }

        return view('recipes.edit', [
            'recipe' => $recipe,
            'meal' => Meal::getWithCache(),
        ]);
    }

    /**
     * Update single recipe
     * This method triggers event RecipeIsReady
     * @param RecipeUpdateRequest $request
     * @param Recipe $recipe
     * @return RecipeUpdateResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        if (!user()->hasRecipe($recipe->id)) {
            return back()->withError(trans('recipes.cant_draft'));
        }

        // Move to drafts
        if ($recipe->isReady()) {
            $recipe->moveToDrafts();
            cache()->forget('popular_recipes');
            cache()->forget('random_recipes');
            cache()->forget('unapproved_notif');

            return redirect("/recipes/{$recipe->slug}/edit")->withSuccess(
                trans('recipes.saved')
            );
        }

        if ($this->checkForScriptTags($request)) {
            return back()->withError(trans('notifications.cant_use_script_tags'));
        }

        if ($request->file('image') && $recipe->image != 'default.jpg') {
            try {
                DeleteFileJob::dispatch([
                    "public/recipes/$recipe->image",
                    "public/small/recipes/$recipe->image",
                ]);
            } catch (ConnectionException $e) {
                logger()->error("DeleteFileJob was not dispatched. {$e->getMessage()}");
            }
        }

        $image_name = $this->saveImageIfExist($request->file('image'), $recipe->slug);
        $this->updateRecipe($request, $image_name, $recipe);

        return new RecipeUpdateResponse($recipe);
    }

    /**
     * @param Recipe $recipe
     * @return string
     */
    public function destroy(Recipe $recipe): string
    {
        if ($recipe->user_id !== user()->id) {
            return 'failed';
        }

        if ($recipe->image != 'default') {
            try {
                DeleteFileJob::dispatch([
                    "public/recipes/$recipe->image",
                    "public/small/recipes/$recipe->image",
                ]);
            } catch (ConnectionException $e) {
                logger()->error("DeleteFileJob was not dispatched. {$e->getMessage()}");
            }
        }

        $recipe->categories()->detach();
        $recipe->likes()->delete();
        $recipe->views()->delete();
        $recipe->favs()->delete();

        cache()->forget('popular_recipes');
        cache()->forget('random_recipes');
        cache()->forget('unapproved_notif');

        return $recipe->delete() ? 'success' : 'failed';
    }
}
