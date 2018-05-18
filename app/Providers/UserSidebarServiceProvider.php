<?php

namespace App\Providers;

use App\Models\Recipe;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class UserSidebarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
		if (Schema::hasTable('notifications') && Schema::hasTable('recipes') && Schema::hasTable('feedback')) {
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
			
					// Unapproved recipes
					$allunapproved = Recipe::whereApproved(0)->whereReady(1)->count();
					$allunapproved = !empty($allunapproved) ? 'data-notif='.$allunapproved : '';

					// Feedback
					$allfeedback = Feedback::where('created_at', '>', user()->contact_check)->count();
					$allfeedback = !empty($allfeedback) ? 'data-notif='.$allfeedback : '';

					$view->with(compact(
						'allunapproved', 'allfeedback', 'notifications'
					));
				}
			});
		} else {
			\Log::emergency(trans('logs.no_table', ['table' => 'notifications']));
			\Log::emergency(trans('logs.no_table', ['table' => 'recipes']));
			\Log::emergency(trans('logs.no_table', ['table' => 'feedback']));
		}
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
