<?php

namespace App\Http\ViewComposers\Navbar;

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

        $notifs_notif = count(user()->unreadNotifications) > 0;
        $view->with(compact('notifs_notif'));
    }
}
