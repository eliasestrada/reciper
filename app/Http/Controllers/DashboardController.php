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
    }

    // INDEX
    public function index()
    {
		$user = auth()->user();

        $recipes = DB::table('recipes')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);

        

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

        // Count recipes and visits
        $allrecipes = DB::table('recipes')
                ->count();
        $allvisits = DB::table('visitor_registry')
                ->count();
        $allclicks = DB::table('visitor_registry')
				->sum('clicks');
				
		$allunapproved = DB::table('recipes')
                ->where([['approved', '=', 0], ['ready', '=', 1]])
				->count();
				
		$allunapproved = !empty($allunapproved) ? 'data-notif='.$allunapproved : '';


        if ($user->author !== 1 && $user->admin !== 1) {
                return redirect('/recipes')
                        ->with('success', 'Вы не имеете права посещать эту страницу.');
        }

        return view('dashboard')
                ->withRecipes($recipes)
                ->withAllrecipes($allrecipes)
                ->withAllvisits($allvisits)
				->withAllclicks($allclicks)
				->withAllunapproved($allunapproved)
                ->withNotifications($notifications);
    }

    // NOTIFICATIONS
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

        return view('notifications')
                ->withNotifications($notifications);
	}
	
	// CHECKLIST
    public function checklist() {

		$unapproved = DB::table('recipes')
                ->where([['approved', '=', 0], ['ready', '=', 1]])
                ->oldest()
				->paginate(10);

		return view('checklist')
				->withUnapproved($unapproved);
    }
}