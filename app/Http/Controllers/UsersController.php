<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Notification;

class UsersController extends Controller
{

	public function __construct()
    {
		$this->middleware('author')->except(['show', 'index']);
	}


	public function index()
	{
        return view('users.index')->withUsers(User::simplePaginate(30));
	}


	public function show(User $user)
    {
		$recipes = Recipe::whereUserId($user->id)->latest()->paginate(20);
		return view('users.show')->with(compact('recipes', 'user'));
	}

	// Show all my recipes
	public function my_recipes()
	{
		$recipes = Recipe::whereUserId(user()->id)->latest()->paginate(20);

		return view('users.my_recipes')->withRecipes($recipes);
	}

	public function notifications()
	{
        $notifications = Notification::whereUserId(user()->id)
			->orWhere('for_admins', 1)
			->latest()
			->paginate(10);

		User::whereId(user()->id)->update([
			'notif_check' => NOW()
		]);

		return view('users.notifications')
			->withNotifications($notifications);
	}
}