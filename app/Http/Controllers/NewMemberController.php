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
				trans('new_member.member_has_been_added')
			);
		} else {
			return back()->withError(
				trans('new_member.not_found')
			);
		}
	}


    public function delete($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->delete();
			return back()->withSuccess(
				trans('new_member.member_has_been_deleted')
			);
		} else {
			return back()->withError(
				trans('new_member.not_found')
			);
		}
	}
}
