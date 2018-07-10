<?php

namespace App\Http\ViewComposers\UserMenu;

use Schema;
use Illuminate\View\View;
use App\Models\Notification;

class NotificationsComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) : void
    {
		if (Schema::hasTable('notifications')) {
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
				$view->with('notifications', getDataNotifMarkup($notifications));
			}
		} else {
			logger()->emergency("Table notifications wasn't found while trying to count all unproved recipes, name of the method: countAndComposeAllNotifications");
		}
    }
}