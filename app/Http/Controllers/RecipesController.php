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
			'Рецепт успешно сохранен'
		);
    }

    // It will show the recipe on a single page
    public function show($id)
    {
		$recipe = Recipe::find($id);

        // Rules for visitors
        if (!user() && !$recipe->approved()) {
            return redirect('/recipes')->withError(
				'У вас нет права просматривать этот рецепт, 
				так как он еще не опубликован'
			);
		}

        // Rules for auth users
        if (user()) {
            if (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(
					'У вас нет права на просмотр этого рецепта'
				);
            } elseif (!user()->hasRecipe($recipe->user_id) && !$recipe->ready()) {
                return redirect('/recipes')->withError(
					'Этот рецепт находится в процессе написания.'
				);
			} elseif (!user()->isAdmin() && !user()->hasRecipe($recipe->user_id) && !$recipe->approved()) {
                return redirect('/recipes')->withError(
					'Этот рецепт еще не одобрен.'
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
				'Вы не можете редактировать не свои рецепты.'
			);
        }

        if ($recipe->ready() && !user()->isAdmin()) {
			return redirect('/recipes')->withError(
				'Вы не можете редактировать рецепты которые находятся на 
				рассмотрении или уже опубликованны.'
			);
        }

        // For select input
        $categories = DB::table('categories')->get();
        return view('recipes.edit')->with([
			'recipe'     => $recipe,
			'categories' => $categories
		]);
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
				'Рецепт успешно сохранен'
			);
        } elseif ($recipe->ready() && user()->isAdmin()) {
            return redirect('/recipes')->withSuccess(
				'Рецепт опубликован и доступен для посетителей.'
			);
        }
        return redirect('/dashboard')->withSuccess(
			'Рецепт добавлен на рассмотрение и будет опубликован после 
			одобрения администрации.'
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
    public function answer($id, Request $request)
    {
        $update_recipe = Recipe::where([
			[ 'id', $id ],
			[ 'approved', 0 ],
			[ 'ready', 1 ]
		]);

		$recipe = Recipe::find($id);

        if ($request->input('answer') == 'approve') {
			
			$update_recipe->update([
				'approved' => 1
			]);

            Notification::insert([
				'user_id'    => $recipe->user_id,
				'title'      => 'Рецепт опубликован',
				'message'    => 'Рецепт под названием "' . $recipe->title . '" был опубликован.',
				'for_admins' => 0,
				'created_at' => NOW(),
				'updated_at' => NOW()
			]);

			return redirect('/recipes')->withSuccess(
				'Рецепт одобрен и опубликован.'
			);

        } elseif ($request->input('answer') == 'cancel') {

			$update_recipe->update([
				'ready' => 0
			]);

            Notification::insert([
				'user_id'    => $recipe->user_id,
				'title'      => 'Рецепт не опубликован',
				'message'    => 'Рецепт под названием "' . $recipe->title . '" не был опубликован 
								так как администрация венула его вам на переработку.',
				'for_admins' => 0,
				'created_at' => NOW(),
				'updated_at' => NOW()
			]);

            return redirect('/recipes')->withSuccess(
				'Вы вернули рецепт на повторное редактирование'
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
				'Вы не можете редактировать не свои рецепты'
			);
        }
		$recipe->delete();

        return redirect('/my_recipes')->withSuccess('Рецепт успешно удален');
	}
}
