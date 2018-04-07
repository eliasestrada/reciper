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

	/* INDEX
	====================== */

    public function index()
    {
		$feedback = Feedback::paginate(40);

		// Mark that user saw these messages
		User::where('id', auth()->user()->id)->update([
			'contact_check' => NOW()
		]);

		return view('feedback.index')->with(
			'feedback', $feedback
		);
	}

	/* DELETE
	====================== */

	public function destroy($id)
	{
		$feedback = Feedback::find($id);
		$messageError = 'Только админ может удалять эти сообщения!';
		$messageSuccess = 'Отзыв успешно удален';

        // Check for correct user
        if (!auth()->user()->isAdmin()) {
            return redirect('/feedback')->with(
				'error', $messageError
			);
        }
		$feedback->delete();

        return redirect('/feedback')->with(
			'success', $messageSuccess
		);
	}
}