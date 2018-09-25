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

        $notifs_notif = Notification::where([
            ['user_id', user()->id],
            ['created_at', '>', user()->notif_check],
        ])->exists();

        if (user()->hasRole('admin')) {
            $admin_notif = Notification::where([
                ['for_admins', 1],
                ['created_at', '>', user()->notif_check],
            ])->exists();
            $notifs_notif = $admin_notif ? $admin_notif : $notifs_notif;
        }
        $view->with(compact('notifs_notif'));
    }
}
