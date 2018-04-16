<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\Recipe;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('author');
		$this->middleware('admin')->only('checklist');
	}

	/**
	 * Index. Dashboard
	 */
    public function index()
    {
		$user = auth()->user();

		// Update last visit
		User::whereId($user->id)->update([
			'updated_at' => NOW()
		]);

        $notifications = Notification::where([
			['user_id', $user->id],
			['created_at', '>', $user->notif_check]
		])->count();

		if ($user->isAdmin()) {
			$notifications_for_admin = Notification::where([
				['for_admins', 1],
				['created_at', '>', $user->notif_check]
			])->count();

			$notifications += $notifications_for_admin;
		}

        $notifications = empty($notifications) ? '' : 'data-notif='.$notifications;

		// Unapproved recipes
		$allunapproved = Recipe::whereApproved(0)->whereReady(1)->count();
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

	/**
	 * Show all Notifications
	 */
    public function notifications() {

		$user_id = auth()->user()->id;

        $notifications = Notification::whereUserId($user_id)
				->orWhere('for_admins', 1)
				->latest()
				->paginate(10);

		User::whereId($user_id)->update([
			'notif_check' => NOW()
		]);

        return view('notifications')->with(
			'notifications', $notifications
		);
	}

	/**
	 * Checklist shows all recipes that need to be approved
	 * by administration
	 */
    public function checklist() {

		$unapproved = Recipe::whereApproved(0)
				->whereReady(1)
				->oldest()
				->paginate(10);

		return view('checklist')->with(
			'unapproved', $unapproved
		);
	}

	/**
	 * Show all my recipes
	 */
    public function my_recipes() {

		$user = auth()->user();
		$recipes = Recipe::whereUserId($user->id)->latest()->paginate(20);

		return view('my_recipes')->with(
			'recipes', $recipes
		);
	}
}