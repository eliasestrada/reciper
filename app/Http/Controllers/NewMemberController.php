<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewMemberController extends Controller
{
	public function __construct()
    {
		$this->middleware('admin');
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
