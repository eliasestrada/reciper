<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
		DB::table('users')->where('id', $user->id)->update(['updated_at' => NOW()]);

        $notifications = DB::table('notifications')
				->where([['user_id', $user->id], ['created_at', '>', $user->notif_check]])
				->count();

		if ($user->admin === 1) {
			$notifications_for_admin = DB::table('notifications')
				->where([['for_admins', 1], ['created_at', '>', $user->notif_check]])
				->count();

			$notifications += $notifications_for_admin;
		}

        $notifications = empty($notifications) ? '' : 'data-notif='.$notifications;

		// Unapproved recipes
		$allunapproved = DB::table('recipes')
                ->where([['approved', '=', 0], ['ready', '=', 1]])
				->count();
		$allunapproved = !empty($allunapproved) ? 'data-notif='.$allunapproved : '';

		// Feedback
		$allfeedback = DB::table('contact')
				->where('created_at', '>', $user->contact_check)
				->count();
		$allfeedback = !empty($allfeedback) ? 'data-notif='.$allfeedback : '';

		return view('dashboard')
				->with([
					'allunapproved' => $allunapproved,
					'allfeedback' => $allfeedback,
					'notifications' => $notifications
				]);
    }

	/* NOTIFICATIONS
	====================== */

    public function notifications() {

		$user_id = auth()->user()->id;

        $notifications = DB::table('notifications')
				->where('user_id', $user_id)
				->orWhere('for_admins', 1)
				->latest()
				->paginate(10);

		DB::table('users')
				->where('id', $user_id)
				->update(['notif_check' => NOW()]);

        return view('notifications')->with('notifications', $notifications);
	}

	/* CHECKLIST
	====================== */

    public function checklist() {

		$unapproved = DB::table('recipes')
                ->where([['approved', '=', 0], ['ready', '=', 1]])
                ->oldest()
				->paginate(10);

		return view('checklist')->with('unapproved', $unapproved);
	}

	/* MY_RECIPES
	====================== */

    public function my_recipes() {

		$user = auth()->user();

		$recipes = DB::table('recipes')
				->where('user_id', $user->id)
				->latest()
				->paginate(20);

		return view('my_recipes')->with('recipes', $recipes);
	}
}