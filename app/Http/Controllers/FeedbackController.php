<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
	}

    public function index()
    {
		$user = auth()->user();

        $feedback = DB::table('contact')
                ->latest()
				->paginate(20);

		// Mark that user saw these messages
		DB::table('users')
				->where('id', $user->id)
				->update(['contact_check' => NOW()]);

		return view('feedback.index')
				->withFeedback($feedback);
    }

    /* CREATE
	====================== */

    public function create()
    {
        //
    }

    /* STORE
	====================== */

    public function store(Request $request)
    {
        //
    }

    /* SHOW
	====================== */

    public function show($id)
    {
        //
    }

    /* EDIT
	====================== */

    public function edit($id)
    {
        //
    }

    /* UPDATE
	====================== */

    public function update(Request $request, $id)
    {
        //
    }

    /* DESTROY
	====================== */

    public function destroy($id)
    {
        //
    }
}
