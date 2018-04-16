<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;

class ApiRecipesController extends Controller
{
	/**
	 * All approved recipes
	 */
    public function index() {
		$recipes = Recipe::whereApproved(1)->latest()->paginate(30);

		return RecipeResource::collection($recipes);
	}
}
