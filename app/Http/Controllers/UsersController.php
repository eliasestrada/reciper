<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersController extends Controller
{
    // INDEX
    public function index() {
		$users = DB::table('users')->paginate(30);

        return view('users.index')->withUsers($users);
	}

	// CREATE
    public function create()
    {
        //
    }

	// STORE
    public function store(Request $request)
    {
        //
    }


    // SHOW
	public function show($id)
    {
		$user = User::find($id);

		return view('users.show')->withUser($user);
	}

	// EDIT
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    // DESTROY
    public function destroy($id)
    {
        //
    }
}
