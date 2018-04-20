<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\User;

class UsersController extends Controller
{

	public function __construct()
    {
		$this->middleware('author');
	}


    public function index() {
        return view('users.index')->withUsers(User::simplePaginate(30));
	}


	public function show($id)
    {
		$user = User::find($id);
		$recipes = Recipe::whereUserId($user->id)->latest()->paginate(20);

		return view('users.show')->with([
			'recipes' => $recipes,
			'user' => $user
		]);
	}


	// Add user to authors
    public function add($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->update(['author' => 1]);
			return back()->withSuccess(
				'Пользователь добавлен и теперь может заходить в свой профиль.'
			);
		} else {
			return back()->withError('Пользователь не найден');
		}
	}


    public function delete($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->delete();
			return back()->withSuccess('Пользователь удален');
		} else {
			return back()->withError('Пользователь не найден');
		}
	}
}