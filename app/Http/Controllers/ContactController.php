<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{

	// Store in feedback table in database
	public function store(ContactRequest $request)
	{
		Feedback::create($request->only('name', 'email', 'message'));

		return redirect()->back()->withSuccess(
			trans('admin.thanks_for_feedback')
		);
	}
}