<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;

class UsersController extends Controller
{

	public function __construct()
    {
		$this->middleware('author');
	}


	public function index()
	{
        return view('users.index')->withUsers(User::simplePaginate(30));
	}


	public function show(User $user)
    {
		$recipes = Recipe::whereUserId($user->id)->latest()->paginate(20);

		return view('users.show')->with([
			'recipes'  => $recipes,
			'user'     => $user
		]);
	}

	// Show all my recipes
	public function my_recipes()
	{
		$recipes = Recipe::whereUserId(user()->id)->latest()->paginate(20);

		return view('users.my_recipes')->withRecipes($recipes);
	}
}