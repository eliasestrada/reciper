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
            $view->with([
                'notifications' => user()
                    ->notifications()
                    ->select('data', 'created_at')
                    ->get()
                    ->toArray(),
            ]);
        }
    }
}
