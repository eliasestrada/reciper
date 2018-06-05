<?php

namespace App\Http\Controllers;

use Cookie;
use App\Models\Title;
use App\Models\Recipe;
use App\Models\Category;
use App\Events\RecipeIsReady;
use App\Http\Requests\RecipeSaveRequest;
use App\Http\Requests\RecipePublichRequest;
use App\Helpers\Traits\RecipesControllerHelpers;
use App\Helpers\Contracts\SaveRecipeDataContract;

class RecipesController extends Controller
{
	use RecipesControllerHelpers;

    public function __construct()
    {
        $this->middleware('auth', ['except' => [
			'index', 'show', 'like', 'dislike'
		]]);
    }

    // Index, show all approved recipes
    public function index()
    {
		return view('recipes.index');
    }


    // Create a new recipe in database
    public function create()
    {
		return view('recipes.create')
			->withCategories(Category::get());	
    }


    /**
	 * It will save the recipe to a database
	 * @see RecipeSaveRequest is validating this method
	 * @see SaveRecipeDataContract
	 */
    public function store(RecipeSaveRequest $request)
    {
		$image_name = $this->saveImageIfExists($request->file('image'));
		$recipe = $this->createOrUpdateRecipe($request, $image_name);

		return redirect('/recipes/'.$recipe->id.'/edit')->withSuccess(
			trans('recipes.recipe_has_been_saved')
		);
    }

    // It will show the recipe on a single page
    public function show(Recipe $recipe)
    {
		$recipe_array = $recipe->toArray();

        // Rules for visitors
        if (!user() && !$recipe->approved()) {
            return redirect('/recipes')->withError(trans('recipes.no_rights_to_see'));
		}

        // Rules for auth users
        if (user()) {
            if (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(trans('recipes.no_rights_to_see'));
			}

			if (!user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(trans('recipes.not_written'));
			}

			if (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->approved()) {
                return redirect('/recipes')->withError(trans('recipes.not_approved'));
			}
		}

		return view('recipes.show')->with([
			'recipe' => $recipe,
			'title' => $recipe_array['title_'.locale()],
			'intro' => $recipe_array['intro_'.locale()],
		]);
    }


    public function edit(Recipe $recipe)
    {
        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(
				trans('recipes.no_rights_to_edit')
			);
        }

        $categories = Category::get();
        return view('recipes.edit')->with(compact(
			'recipe', 'categories'
		));
    }

    /**
	 * Update single recipe
	 * @see RecipePublichRequest
	 */
    public function update(RecipePublichRequest $request, Recipe $recipe)
    {
		// Handle image uploading
		$image_name = $this->saveImageIfExists($request->file('image'), $recipe->image);

		if ($request->file('image')) {
			$this->deleteOldImage($recipe->image);
		}

		$this->createOrUpdateRecipe($request, $image_name, $recipe);

        if (!$recipe->ready()) {
            return back()->withSuccess(trans('recipes.saved'));
		}
		
		if ($recipe->ready() && user()->isAdmin()) {
            return redirect('/recipes')->withSuccess(trans('recipes.recipe_published'));
		}
		event(new RecipeIsReady($recipe));
        return redirect('/dashboard')->withSuccess(trans('recipes.added_to_approving'));
    }


    public function like(Recipe $recipe)
    {
		$recipe->increment('likes');
        return back()->withCookie(cookie('liked', $recipe->id, 5000));
	}

    public function dislike(Recipe $recipe)
    {
		if ($recipe->id == Cookie::get('liked')) {
			$recipe->decrement('likes');
			return back()->withCookie(Cookie::forget('liked'));
		}
		return back();
    }

	// We also deliting image in App\Observers\RecipeObserver
    public function destroy(Recipe $recipe)
    {
        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(trans('recipes.you_cant_edit_recipe'));
		}
		$this->deleteOldImage($recipe->image);
		$recipe->delete();

        return redirect('/users/my_recipes/all')->withSuccess(trans('recipes.deleted'));
	}
}
