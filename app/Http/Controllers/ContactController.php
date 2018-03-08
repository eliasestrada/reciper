<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
	// INDEX
    public function index() {
		return view('pages.contact');
	}
	
	// STORE
	public function store(Request $request) {
	
		$this->validate($request, [
			'имя' => 'required|min:3|max:50',
			'почта' => 'required|email',
			'сообщение' => 'required|min:20|max:5000'
		]);
		
		DB::table('contact')->insert([
			'name' => $request->имя,
			'email' => $request->почта,
			'message' => $request->сообщение,
			'created_at' => NOW()
		]);

		return redirect()->back()
				->with('success', 'Спасибо за ваш отзыв.');
	}

	/* ============================================
	public function store(Request $request) {
	
		$this->validate($request, [
			'имя' => 'required|min:3|max:50',
			'почта' => 'required|email',
			'сообщение' => 'required|min:20|max:5000'
		]);
		
		Mail::send('emails.contact-message', [
			'msg' => $request->сообщение
		], function($mail) use($request) {
			$mail->to('deliciousfood.kh@gmail.com', env('APP_NAME'));
			$mail->from($request->почта, $request->имя);
			$mail->subject('Отправитель: ' . $request->почта);
		});

		return redirect()->back()
				->with('success', 'Спасибо за ваш отзыв.');
	}
	============================================ */
}