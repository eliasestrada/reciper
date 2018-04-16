<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\User;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
	}

	/**
	 * Index
	 */
    public function index()
    {
		// Mark that user saw these messages
		User::whereId(auth()->user()->id)->update([
			'contact_check' => NOW()
		]);

		return view('feedback.index')->with(
			'feedback', Feedback::paginate(40)
		);
	}

	/**
	 * Delete
	 * 
	 * @param string $id
	 */
	public function destroy($id)
	{
        // Check for correct user
        if (!auth()->user()->isAdmin()) {
            return redirect('/feedback')->with(
				'error', 'Только админ может удалять эти сообщения!'
			);
        }
		Feedback::find($id)->delete();

        return redirect('/feedback')->with(
			'success', 'Отзыв успешно удален'
		);
	}
}