<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Recipe;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RecipeSaveRequest;
use App\Http\Requests\RecipePublichRequest;
use App\Helpers\Contracts\SaveRecipeDataContract;

class RecipesController extends Controller
{
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
        // For select input
        $categories = DB::table('categories')->get();
		return view('recipes.create')->withCategories($categories);	
    }


    /**
	 * It will save the recipe to a database
	 * @param RecipeSaveRequest $request is validating this method
	 * @param SaveRecipeDataContract $saveImage
	 */
    public function store(RecipeSaveRequest $request, SaveRecipeDataContract $saveRecipeData)
    {
		$recipe = new Recipe;
		$saveRecipeData->save( $request, $recipe );
		$recipe->save();

		return redirect('/recipes/'.$recipe->id.'/edit') ->withSuccess(
			trans('recipes.recipe_has_been_saved')
		);
    }

    // It will show the recipe on a single page
    public function show(Recipe $recipe)
    {
        // Rules for visitors
        if (!user() && !$recipe->approved()) {
            return redirect('/recipes')->withError(
				trans('recipes.no_rights_to_see')
			);
		}

        // Rules for auth users
        if (user()) {
            if (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(
					trans('recipes.no_rights_to_see')
				);
            } elseif (!user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(
					trans('recipes.is_not_written_yet')
				);
			} elseif (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->approved()) {
                return redirect('/recipes')->withError(
					trans('recipes.not_approved_yet')
				);
			}
		}

		return view('recipes.show')->withRecipe($recipe);
    }


    public function edit($id)
    {
		$recipe = Recipe::find($id);

        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(
				trans('recipes.no_rights_to_edit')
			);
        }

        if ($recipe->ready() && !user()->isAdmin()) {
			return redirect('/recipes')->withError(
				trans('recipes.cannot_edit_unproved')
			);
        }

        // For select input
        $categories = DB::table('categories')->get();
        return view('recipes.edit')->with(compact(
			'recipe', 'categories'
		));
    }


    /**
	 * Update single recipe
	 * @param RecipePublichRequest $request
	 * @param string $id
	 */
    public function update(RecipePublichRequest $request, $id)
    {
		$recipe = Recipe::find($id);
		$recipe->update($request->except([
			'_token','_method', 'image'
		]));

		$recipe->update([
			'ready'    => isset($request->ready) ? 1 : 0,
			'approved' => user()->isAdmin() ? 1 : 0
		]);

        // Handle image uploading
        if ($request->hasFile('image')) {
            $image    = $request->file('image');
			$filename = time() . rand() . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $filename )
			);

			$recipe->update([
				'image' => $filename
			]);
		}
		$recipe->save();

        if (!$recipe->ready()) {
            return redirect()->back()->withSuccess(
				trans('recipes.saved')
			);
        } elseif ($recipe->ready() && user()->isAdmin()) {
            return redirect('/recipes')->withSuccess(
				trans('recipes.recipe_is_published')
			);
        }
        return redirect('/dashboard')->withSuccess(
			trans('recipes.added_to_approving')
		);
    }


    public function like($id)
    {
		Recipe::find($id)->increment('likes');
        return back()->withCookie(cookie('liked', 1, 5000));
	}
	

    public function dislike($id)
    {
		Recipe::find($id)->decrement('likes');
		return back()->withCookie(Cookie::forget('liked'));
    }


    // Approve the recipe (for admins)
    public function answer($id)
    {
        $update_recipe = Recipe::where([
			[ 'id', $id ], [ 'approved', 0 ], [ 'ready', 1 ]
		]);

		$recipe = Recipe::find($id);

        if (request('answer') == 'approve') {
			$update_recipe->update([ 'approved' => 1 ]);

			Notification::recipeHasBeenApproved($recipe->title, $recipe->user_id);

			return redirect('/recipes')->withSuccess(
				'Рецепт одобрен и опубликован.'
			);

        } elseif (request('answer') == 'cancel') {
			$update_recipe->update([ 'ready' => 0 ]);

            Notification::recipeHasNotBeenCreated($recipe->title, $recipe->user_id);

            return redirect('/recipes')->withSuccess(
				trans('recipes.you_gave_recipe_back_on_editing')
			);
        }
    }

	// We also deliting image in App\Observers\RecipeObserver
    public function destroy($id)
    {
		$recipe = Recipe::find($id);

        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(
				trans('recipes.you_cannot_edit_peoples_recipes')
			);
        }
		$recipe->delete();
		
        return redirect('/my_recipes')->withSuccess(
			trans('recipes.deleted')
		);
	}
}
