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
        if (user()) {
            $notifications = user()
                ->notifications()
                ->select('data', 'created_at', 'read_at')
                ->get();

            $has_notifications = $notifications->where('read_at', '=', null)->count() > 0;

            $view->with('notifications', $notifications->toArray());
            $view->with(compact('has_notifications'));
        }
    }
}
