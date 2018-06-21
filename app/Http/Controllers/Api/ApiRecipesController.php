<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\RecipesRandomResource;
use App\Helpers\Traits\RecipesControllerHelpers;

class ApiRecipesController extends Controller
{
	use RecipesControllerHelpers;

	/**
	 * @return object
	 */
	public function index() : ? object
	{
		$recipes = Recipe
			::where('approved_'.locale(), 1)
			->where('ready_'.locale(), 1)
			->latest()
			->paginate(32);

		return RecipesResource::collection($recipes);
	}

	/**
	 * @param integer $id of the recipe
	 * @return string
	 */
	public function destroy($id) : string
    {
		$recipe = Recipe::find($id);

		$this->deleteOldImage($recipe->image);
		$recipe->categories()->detach();

		if ($recipe->delete()) {
			return 'success';
		}

		logger()->error('An error occured while trying to delete recipe. Recipe data: ' . $recipe);
		return 'failed';
	}

	/**
	 * @param integer $id of the recipe
	 * @return object
	 */
	public function random($id) : ? object
	{
		$random = Recipe
			::inRandomOrder()
			->where('id', '!=', $id)
			->where('ready_'.locale(), 1)
			->where('approved_'.locale(), 1)
			->limit(7)
			->get();

		return RecipesRandomResource::collection($random);
	}

	/**
	 * @return object
	 */
	public function categories() : ? object
	{
		return Category::get(['id', 'name_' . locale()]);
	}

	/**
	 * @param integer $id of the recipe
	 * @return integer
	 */
	public function checkIfLiked($id) : integer
    {
		$visitor = Visitor::whereIp(request()->ip())->first();
		$likes = $visitor->likes()->where('recipe_id', $id)->count();

		return $likes;
	}

	/**
	 * @param integer $id of the recipe
	 * @return object
	 */
	public function like($id) : ? object
	{
		$visitor = Visitor::whereIp(request()->ip())->first();
		Like::create(['visitor_id' => $visitor->id, 'recipe_id' => $id]);

		return response()->json(['liked' => 1]);
	}

	/**
	 * @param integer $id of the recipe
	 * @return object
	 */
	public function dislike($id) : ? object
	{
		$visitor = Visitor::whereIp(request()->ip())->first();
		Like::where(['visitor_id' => $visitor->id, 'recipe_id' => $id])->delete();

		return response()->json(['liked' => 0]);
	}
}
