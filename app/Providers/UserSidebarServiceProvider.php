<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Feedback;
use App\Models\Notification;
use Schema;
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
        if (Schema::hasTable('notifications')) {
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
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'notifications']));
		}
	}


	public function countAndComposeAllFeedback()
	{
		if (Schema::hasTable('feedback')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$feed = Feedback::where('created_at', '>', user()->contact_check)->count();
					$all_feedback = !empty($feed) ? 'data-notif='.$feed : '';
					$view->with(compact('all_feedback'));
				}
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'feedback']));
		}
	}


	public function countAndComposeAllUnprovedRecipes()
	{
		if (Schema::hasTable('recipes_' . locale())) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$recipes = Recipe::whereApproved(0)->whereReady(1)->count();
					$all_unapproved = !empty($recipes) ? 'data-notif='.$recipes : '';
					$view->with(compact('all_unapproved'));
				}
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'recipes_' . locale()]));
		}
	}


	public function countAndComposeNewUsers()
	{
		if (Schema::hasTable('users')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$new_users = User::whereAuthor(0)->count();
					$all_new_users = !empty($new_users) ? 'data-notif='.$new_users : '';
					$view->with(compact('all_new_users'));
				}
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'users']));
		}
	}
}
