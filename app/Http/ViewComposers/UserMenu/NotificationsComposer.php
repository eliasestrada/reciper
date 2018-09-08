<?php

namespace App\Http\ViewComposers\UserMenu;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationsComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (!user()) {
            return;
        }

        $all_notifs = cache()->rememberForever('all_notifs', function () {
            return Notification::where([
                ['user_id', user()->id],
                ['created_at', '>', user()->notif_check],
            ])->count();
        });

        if (user()->isAdmin()) {
            $admin_notifs = cache()->rememberForever('admin_notifs', function () {
                return Notification::where([
                    ['for_admins', 1],
                    ['created_at', '>', user()->notif_check],
                ])->count();
            });
            $all_notifs += $admin_notifs;
        }
        $view->with(compact('all_notifs'));
    }
}
