<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
	public function __construct()
    {
		$this->middleware('author');
	}

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

	// ADD
    public function add($id)
    {
		$user = DB::table('users')->where([['id', $id], ['author', 0]]);

		if ($user) {
			$user->update(['author' => 1]);

			return back()->with('success', 'Пользователь добавлен и теперь может заходить в свой профиль.');
		} else {
			return back()->with('error', 'Пользователь не найден');
		}
	}

	// DELETE
    public function delete($id)
    {
		$user = DB::table('users')->where([['id', $id], ['author', 0]]);

		if ($user) {
			$user->delete();
			return back()->with('success', 'Пользователь удален');
		} else {
			return back()->with('error', 'Пользователь не найден');
		}
	}
}