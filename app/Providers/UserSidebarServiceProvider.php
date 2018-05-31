<?php

namespace App\Providers;

use App\Models\Recipe;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Support\Facades\Schema;
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
			logger()->emergency(trans('logs.no_table', ['table' => 'notifications']));
		}
	}


	public function countAndComposeAllFeedback()
	{
		if (Schema::hasTable('feedback')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$allfeedback = Feedback::where('created_at', '>', user()->contact_check)->count();
					$allfeedback = !empty($allfeedback) ? 'data-notif='.$allfeedback : '';
					$view->with(compact('allfeedback'));
				}
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'feedback']));
		}
	}


	public function countAndComposeAllUnprovedRecipes()
	{
		if (Schema::hasTable('recipes')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$allunapproved = Recipe::whereApproved(0)->whereReady(1)->count();
					$allunapproved = !empty($allunapproved) ? 'data-notif='.$allunapproved : '';
					$view->with(compact('allunapproved'));
				}
			});
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'recipes']));
		}
	}
}
