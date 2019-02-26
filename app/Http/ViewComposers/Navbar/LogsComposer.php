<?php

namespace App\Http\ViewComposers\Navbar;

use File;
use Illuminate\View\View;

class LogsComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (user() && user()->hasRole('master')) {
            $view->with('logs_notif', count(File::files(storage_path('logs'))) > 0 ? true : false);
        } else {
            $view->with('logs_notif', false);
        }
    }
}
