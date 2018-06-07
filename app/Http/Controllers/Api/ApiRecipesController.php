<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\RecipesRandomResource;
use App\Helpers\Traits\RecipesControllerHelpers;
use App\Http\Resources\RecipeCategoriesResource;

class ApiRecipesController extends Controller
{
	use RecipesControllerHelpers;

	// All approved recipes
	public function index()
	{
		$recipes = Recipe
			::where('approved_'.locale(), 1)
			->where('ready_'.locale(), 1)
			->latest()
			->paginate(32);

		return RecipesResource::collection($recipes);
	}


	public function showRandomRecipes($id)
	{
		$random = Recipe
			::inRandomOrder()
			->where('id', '!=', $id)
			->where('approved_'.locale(), 1)
			->limit(7)
			->get();

		return RecipesRandomResource::collection($random);
	}


	public function categories()
	{
		return Category::get(['id', 'name_'.locale()]);
	}


	public function recipeCategories($id)
	{
		$categories = Recipe
			::whereId($id)
			->with('categories')
			->first()
			->categories;
		return RecipeCategoriesResource::collection($categories);
	}


	public function destroy($id)
    {
		$recipe = Recipe::find($id);

		$this->deleteOldImage($recipe->image);
		$recipe->categories()->detach();

		if ($recipe->delete()) {
			return 'success';
		}

		logger()->error(trans('recipes.deleted_fail'));
		return 'failed';
    }
}
