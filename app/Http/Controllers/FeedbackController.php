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

	/* INDEX
	====================== */

    public function index()
    {
		$user = auth()->user();

        $feedback = DB::table('contact')->latest()->paginate(20);

		// Mark that user saw these messages
		DB::table('users')
				->where('id', $user->id)
				->update(['contact_check' => NOW()]);

		return view('feedback.index')->with('feedback', $feedback);
    }
}
