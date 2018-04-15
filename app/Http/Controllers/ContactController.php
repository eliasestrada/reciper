<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Feedback;

class ContactController extends Controller
{
	/**
	 * Index. Show contact page for visitors
	 */
    public function index() {
		return view('pages.contact');
	}

	/**
	 * Store in feedback table in database
	 * 
	 * @param Request $request
	 */
	public function store(Request $request) {

		$this->validate($request, [
			'имя' => 'required|min:3|max:50',
			'почта' => 'required|email',
			'сообщение' => 'required|min:20|max:5000'
		]);

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