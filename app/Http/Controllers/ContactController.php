<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
	/**
	 * Store in feedback table in database
	 * @param ContactRequest $request
	 */
	public function store(ContactRequest $request)
	{
		Feedback::create($request->only('email', 'message'));

		return back()->withSuccess(
			trans('admin.thanks_for_feedback')
		);
	}
}