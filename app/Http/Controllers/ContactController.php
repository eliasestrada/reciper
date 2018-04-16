<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
	/**
	 * Store in feedback table in database
	 * 
	 * @param ContactRequest $request
	 */
	public function store(ContactRequest $request) {

		Feedback::insert([
			'name' => $request->имя,
			'email' => $request->почта,
			'message' => $request->сообщение
		]);

		return redirect()->back()->with(
			'success', 'Спасибо за ваш отзыв.'
		);
	}
}