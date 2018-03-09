<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    // INDEX
    public function index() {
		$users = DB::table('users')->paginate(30);

        return view('users.index')->withUsers($users);
	}

    // SHOW
	public function show($id)
    {
		$user = User::find($id);

		$recipes = DB::table('recipes')
				->where('user_id', $user->id)
				->latest()
				->paginate(20);

		return view('users.show')
				->withRecipes($recipes)
				->withUser($user);
	}
}
