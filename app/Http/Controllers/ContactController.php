<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{

	// Store in feedback table in database
	public function store(ContactRequest $request) {

		Feedback::insert([
			'name' => $request->имя,
			'email' => $request->почта,
			'message' => $request->сообщение
		]);

		return redirect()->back()->withSuccess(
			'Спасибо за ваш отзыв.'
		);
	}
}
