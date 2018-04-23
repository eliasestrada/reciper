<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;

class FeedbackController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
	}


    public function index()
    {
		// Mark that user saw these messages
		User::whereId(user()->id)->update([
			'contact_check' => NOW()
		]);

		return view('feedback.index')->withFeedback(Feedback::paginate(40));
	}


	public function destroy($id)
	{
        // Check for correct user
        if (!user()->isAdmin()) {
            return redirect('/feedback')->withError(
				'Только админ может удалять эти сообщения!'
			);
        }
		Feedback::find($id)->delete();

        return redirect('/feedback')->withSuccess('Отзыв успешно удален');
	}
}