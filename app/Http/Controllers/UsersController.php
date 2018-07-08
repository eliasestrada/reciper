<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Recipe;

class UsersController extends Controller
{
	public function index()
	{
        return view('users.index', ['users' => User::simplePaginate(30)]);
	}

	/**
	 * @param User $user
	 */
	public function show(User $user)
    {
		$recipes = Recipe
			::whereUserId($user->id)
			->withCount('likes')
			->latest()
			->paginate(20);

		$likes = 0;

		foreach ($recipes->toArray()['data'] as $recipe) {
			$likes += $recipe['likes_count'];
		}

		return view('users.show', compact('recipes', 'user', 'likes'));
	}

	public function my_recipes()
	{
		$recipes = Recipe::whereUserId(user()->id)->latest()->paginate(20);

		return view('users.other.my-recipes', compact('recipes'));
	}
}