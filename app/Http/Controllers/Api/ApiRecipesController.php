<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Http\Resources\RecipesRandomResource;

class ApiRecipesController extends Controller
{
	
	// All approved recipes
	public function index()
	{
		$recipes = Recipe::whereApproved(1)->latest()->paginate(32);

		return RecipesResource::collection($recipes);
	}


	public function showRandomRecipes($id)
	{
		$random = Recipe::inRandomOrder()
			->where('id', '!=', $id)
			->whereApproved(1)
			->limit(7)
			->get();

		return RecipesRandomResource::collection($random);
	}
}
