<?php

namespace App\Http\Controllers;

use App\Models\User;

class NewMemberController extends Controller
{
	public function __construct()
    {
		$this->middleware('admin');
	}

    /**
	 * Add user to authors
	 * @param integer $id
	 */
    public function add($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->update(['author' => 1]);
			return back()->withSuccess(trans('new_member.member_has_been_added'));
		} else {
			return back()->withError(trans('new_member.not_found'));
		}
	}

	 /**
	 * Delete user from database
	 * @param integer $id
	 */
    public function delete($id)
    {
		$user = User::whereId($id)->whereAuthor(0);

		if ($user) {
			$user->delete();
			return back()->withSuccess(trans('new_member.member_has_been_deleted'));
		} else {
			return back()->withError(trans('new_member.not_found'));
		}
	}
}
