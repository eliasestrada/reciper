<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;

class DashboardController extends Controller
{

    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('author');
		$this->middleware('admin')->only('checklist');
	}


    public function index()
    {
		return view('dashboard');
    }

	// Show all Notifications
	public function notifications()
	{

        $notifications = Notification::whereUserId(user()->id)
			->orWhere('for_admins', 1)
			->latest()
			->paginate(10);

		User::whereId(user()->id)->update([
			'notif_check' => NOW()
		]);

        return view('notifications')->withNotifications($notifications);
	}
}
