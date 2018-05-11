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
	 * @see RecipeSaveRequest is validating this method
	 * @see SaveRecipeDataContract
	 */
    public function store(RecipeSaveRequest $request)
    {
		$image_name = 'default.jpg';

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$extention = $image->getClientOriginalExtension();
			$image_name = setNameForRecipeImage($extention);

			Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $image_name
			));
		}

		$recipe = user()->recipes()->create([
			'image' 	  => $image_name,
			'category_id' => request('category_id'),
			'title'    	  => request('title'),
			'intro'		  => request('intro'),
			'ingredients' => request('ingredients'),
			'advice' 	  => request('advice'),
			'text' 		  => request('text'),
			'time'		  => request('time')
		]);


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


    public function edit(Recipe $recipe)
    {
        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(
				trans('recipes.no_rights_to_edit')
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
	 * @see RecipePublichRequest
	 */
    public function update(RecipePublichRequest $request, Recipe $recipe)
    {
		// Handle image uploading
		if ($request->hasFile('image')) {
			if ($recipe->image != 'default.jpg') {
				Storage::delete('public/images/'.$recipe->image);
			}

			$image     = $request->file('image');
			$extention = $image->getClientOriginalExtension();
			$image_name = setNameForRecipeImage($extention);

			Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $image_name )
			);

			$recipe->update([ 'image' => $image_name ]);
		}
		$recipe->update( $request->except([ '_token','_method', 'image' ]) );

		$recipe->update([
			'ready'    => isset($request->ready) ? 1 : 0,
			'approved' => user()->isAdmin() ? 1 : 0
		]);

        if (!$recipe->ready()) {
            return back()->withSuccess(
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


    public function like(Recipe $recipe)
    {
		$recipe->increment('likes');
        return back()->withCookie(cookie('liked', 1, 5000));
	}

    public function dislike(Recipe $recipe)
    {
		$recipe->decrement('likes');
		return back()->withCookie(Cookie::forget('liked'));
    }

	// We also deliting image in App\Observers\RecipeObserver
    public function destroy(Recipe $recipe)
    {
        // Check for correct user
        if (!user()->hasRecipe($recipe->user_id) && !user()->isAdmin()) {
            return redirect('/recipes')->withError(
				trans('recipes.you_cannot_edit_peoples_recipes')
			);
		}

		$recipe->delete();

        return redirect('/users/my_recipes/all')->withSuccess(
			trans('recipes.deleted')
		);
	}
}
