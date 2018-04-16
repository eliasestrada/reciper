<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\User;

class UsersController extends Controller
{
	public function __construct()
    {
		$this->middleware('author');
	}

    /**
	 * Index. Show all users
	 */
    public function index() {
        return view('users.index')->with(
			'users', User::paginate(30)
		);
	}

    /**
	 * Show one user
	 * 
	 * @param string $id
	 */
	public function show($id)
    {
		$user = User::find($id);
		$recipes = Recipe::whereUserId($user->id)->latest()->paginate(20);

		return view('users.show')->with([
			'recipes' => $recipes,
			'user' => $user
		]);
	}

	/**
	 * Add user to authors
	 * 
	 * @param string $id
	 */
    public function add($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->update(['author' => 1]);
			return back()->with(
				'success', 'Пользователь добавлен и теперь может заходить в свой профиль.'
			);
		} else {
			return back()->with(
				'error', 'Пользователь не найден'
			);
		}
	}

	/**
	 * Destroy the user
	 * 
	 * @param string $id
	 */
    public function delete($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->delete();
			return back()->with(
				'success', 'Пользователь удален'
			);
		} else {
			return back()->with(
				'error', 'Пользователь не найден'
			);
		}
	}
}