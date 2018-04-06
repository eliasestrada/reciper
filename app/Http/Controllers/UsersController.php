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

    /* INDEX
	====================== */

    public function index() {
        return view('users.index')->with('users', User::paginate(30));
	}

    /* SHOW
	====================== */

	public function show($id)
    {
		$user = User::find($id);
		$recipes = Recipe::where('user_id', $user->id)->latest()->paginate(20);

		return view('users.show')
				->with([
					'recipes' => $recipes,
					'user' => $user
				]);
	}

	/* ADD
	====================== */

    public function add($id)
    {
		$user = User::where([['id', $id], ['author', 0]]);
		$messageSuccess = 'Пользователь добавлен и теперь может заходить в свой профиль.';
		$messageError = 'Пользователь не найден';

		if ($user) {
			$user->update(['author' => 1]);
			return back()->with('success', $messageSuccess);
		} else {
			return back()->with('error', $messageError);
		}
	}

	/* DELETE
	====================== */

    public function delete($id)
    {
		$user = User::where([['id', $id], ['author', 0]]);

		if ($user) {
			$user->delete();
			return back()->with('success', 'Пользователь удален');
		} else {
			return back()->with('error', 'Пользователь не найден');
		}
	}
}