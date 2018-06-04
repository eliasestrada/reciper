<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;

class UserSidebarServiceProvider extends ServiceProvider
{
    public function boot()
    {
		$this->countAndComposeAllNotifications();
		$this->countAndComposeAllFeedback();
		$this->countAndComposeNewUsers();
		$this->countAndComposeAllUnprovedRecipes();
    }


    public function countAndComposeAllNotifications()
    {
		view()->composer('includes.user-sidebar', function($view) {
			if (user()) {
				$notifications = Notification::where([
					['user_id', user()->id],
					['created_at', '>', user()->notif_check]
				])->count();

				if (user()->isAdmin()) {
					$notifications_for_admin = Notification::where([
						[ 'for_admins', 1 ],
						[ 'created_at', '>', user()->notif_check ]
					])->count();
					$notifications += $notifications_for_admin;
				}

				$notifications = empty($notifications) ? '' : 'data-notif='.$notifications;
				$view->with(compact('notifications'));
			}
		});
	}


	public function countAndComposeAllFeedback()
	{
		view()->composer('includes.user-sidebar', function($view) {
			if (user()) {
				$feed = Feedback::where('created_at', '>', user()->contact_check)->count();
				$all_feedback = !empty($feed) ? 'data-notif='.$feed : '';
				$view->with(compact('all_feedback'));
			}
		});
	}


	public function countAndComposeAllUnprovedRecipes()
	{
		view()->composer('includes.user-sidebar', function($view) {
			if (user()) {
				$recipes = Recipe::whereApproved(0)->whereReady(1)->count();
				$all_unapproved = !empty($recipes) ? 'data-notif='.$recipes : '';
				$view->with(compact('all_unapproved'));
			}
		});
	}


	public function countAndComposeNewUsers()
	{
		view()->composer('includes.user-sidebar', function($view) {
			if (user()) {
				$new_users = User::whereAuthor(0)->count();
				$all_new_users = !empty($new_users) ? 'data-notif='.$new_users : '';
				$view->with(compact('all_new_users'));
			}
		});
	}
}
