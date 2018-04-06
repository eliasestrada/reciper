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
		$user = auth()->user();
		$feedback = Feedback::paginate(40);

		// Mark that user saw these messages
		User::where('id', $user->id)->update(['contact_check' => NOW()]);

		return view('feedback.index')->with('feedback', $feedback);
	}

	/* DELETE
	====================== */

	public function destroy($id)
	{
		$feedback = Feedback::find($id);
		$user = auth()->user();
		$messageError = 'Только админ может удалять эти сообщения!';
		$messageSuccess = 'Отзыв успешно удален';

        // Check for correct user
        if ($user->admin !== 1) {
            return redirect('/feedback')->with('error', $messageError);
        }

		$feedback->delete();
        return redirect('/feedback')->with('success', $messageSuccess);
	}
}
