<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Feedback;
use App\Recipe;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('author');
		$this->middleware('admin')->only('checklist');
	}

	/* INDEX
	====================== */

    public function index()
    {
		$user = auth()->user();

		// Update last visit
		User::where('id', $user->id)->update([
			'updated_at' => NOW()
		]);

        $notifications = Notification::where([
			['user_id', $user->id],
			['created_at', '>', $user->notif_check]
		])->count();

		if ($user->isAdmin) {
			$notifications_for_admin = Notification::where([
				['for_admins', 1],
				['created_at', '>', $user->notif_check]
			])->count();

			$notifications += $notifications_for_admin;
		}

        $notifications = empty($notifications) ? '' : 'data-notif='.$notifications;

		// Unapproved recipes
		$allunapproved = Recipe::where([
			['approved', '=', 0],
			['ready', '=', 1]
		])->count();
		$allunapproved = !empty($allunapproved) ? 'data-notif='.$allunapproved : '';

		// Feedback
		$allfeedback = Feedback::where('created_at', '>', $user->contact_check)->count();
		$allfeedback = !empty($allfeedback) ? 'data-notif='.$allfeedback : '';

		return view('dashboard')->with([
			'allunapproved' => $allunapproved,
			'allfeedback' => $allfeedback,
			'notifications' => $notifications
		]);
    }

	/* NOTIFICATIONS
	====================== */

    public function notifications() {

		$user_id = auth()->user()->id;

        $notifications = Notification::where('user_id', $user_id)
				->orWhere('for_admins', 1)
				->latest()
				->paginate(10);

		User::where('id', $user_id)->update([
			'notif_check' => NOW()
		]);

        return view('notifications')->with(
			'notifications', $notifications
		);
	}

	/* CHECKLIST
	====================== */

    public function checklist() {

		$unapproved = Recipe::where([
			['approved', '=', 0],
			['ready', '=', 1]
		])->oldest()->paginate(10);

		return view('checklist')->with(
			'unapproved', $unapproved
		);
	}

	/* MY_RECIPES
	====================== */

    public function my_recipes() {

		$user = auth()->user();
		$recipes = Recipe::where('user_id', $user->id)->latest()->paginate(20);

		return view('my_recipes')->with(
			'recipes', $recipes
		);
	}
}