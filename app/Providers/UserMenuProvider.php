<?php

namespace App\Providers;

use Schema;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;

class UserMenuProvider extends ServiceProvider
{
	/**
	 * Bootstrap services
     * @return void
     */
    public function boot() : void
    {
		$this->countAndComposeAllNotifications();
		$this->countAndComposeAllFeedback();
		$this->countAndComposeAllUnprovedRecipes();
    }

	/**
     * @return void
     */
    public function countAndComposeAllNotifications() : void
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
					$view->withNotifications($this->getDataNotifMarkup($notifications));
				}
			});
		} else {
			$this->log('notifications', 'countAndComposeAllNotifications');
		}
	}

	/**
     * @return void
     */
	public function countAndComposeAllFeedback() : void
	{
		if (Schema::hasTable('feedback')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$feed = Feedback::where('created_at', '>', user()->contact_check)->count();
					$view->withAllFeedback($this->getDataNotifMarkup($feed));
				}
			});
		} else {
			$this->log('feedback', 'countAndComposeAllFeedback');
		}
	}

	/**
     * @return void
     */
	public function countAndComposeAllUnprovedRecipes() : void
	{
		if (Schema::hasTable('recipes')) {
			view()->composer('includes.user-sidebar', function($view) {
				if (user()) {
					$recipes = Recipe::where("approved_" . locale(), 0)
						->where("ready_" . locale(), 1)
						->count();
					$all_unapproved = $this->getDataNotifMarkup($recipes);
					$view->with(compact('all_unapproved'));
				}
			});
		} else {
			$this->log('recipes', 'countAndComposeAllUnprovedRecipes');
		}
	}

	/**
	 * Helper
	 * @return string
	 * @param int $data
	 */
	public function getDataNotifMarkup($data) : string
	{
		return !empty($data) ? 'data-notif=' . $data : '';
	}

	/**
	 * Helper
	 * @param string $table
	 * @param string $method
	 */
	public function log($table, $method)
	{
		return logger()->emergency("Table $table wasn't found while trying to count all unproved recipes, name of the method: $method");
	}
}
