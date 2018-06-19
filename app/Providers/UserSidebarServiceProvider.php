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
			logger()->emergency("Table notifications wasn't found while trying to count all notifications, name of the method: countAndComposeAllNotifications");
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
			logger()->emergency("Table feedback wasn't found while trying to count all feedback messages, name of the method: countAndComposeAllFeedback");
		}
	}


	public function countAndComposeAllUnprovedRecipes()
	{
		if (Schema::hasTable('recipes')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$recipes = Recipe
						::where("approved_" . locale(), 0)
						->where("ready_" . locale(), 1)
						->count();
					$all_unapproved = !empty($recipes) ? 'data-notif='.$recipes : '';
					$view->with(compact('all_unapproved'));
				}
			});
		} else {
			logger()->emergency("Table recipes wasn't found while trying to count all unproved recipes, name of the method: countAndComposeAllUnprovedRecipes");
		}
	}
}
